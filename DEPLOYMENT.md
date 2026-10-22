# Deploying Unite Systems to GitHub + AWS

This guide covers pushing this project to GitHub and deploying it to an AWS EC2
instance, bringing over **all the current sample content** (homepage copy, job
postings, logo/hero images, settings) so the live site looks the same as your
local Laragon install at first launch.

---

## 1. What ships in this repo

- Full Laravel 12 + Filament 5 application code.
- `storage/app/public/branding/*` and `storage/app/public/content/*` — your
  uploaded logo, favicon, and hero images (tracked in git on purpose so a
  fresh clone already has them).
- `database/seed-data/content-seed.sql` — a data-only SQL export of the
  `content_texts`, `content_items`, `job_postings`, and `settings` tables
  (everything the admin panel lets you edit: page copy, nav/footer links,
  the "Human expertise" section, testimonials, job listings, site settings).
- **Not included (by design):** `.env` (secrets), `users`, `candidate_profiles`,
  `job_applications`, `contact_messages`, `email_logs` — these are
  account/PII-style data from local testing. The server gets a **fresh admin
  account** you create yourself (step 6).

---

## 2. Push to GitHub

The repo has already been initialized locally with an initial commit. Create
an **empty** repository on GitHub (no README/license/gitignore — this repo
already has those), then:

```powershell
cd C:\laragon\www\unitesystems
git remote add origin https://github.com/<your-username>/<your-repo>.git
git branch -M main
git push -u origin main
```

If you use SSH instead of HTTPS, use `git@github.com:<your-username>/<your-repo>.git`.

> Tell me the repo URL once it's created and I can run the `git remote add`
> / `git push` for you.

---

## 2b. Already have a running server with Apache/PHP/MySQL?

If your EC2 instance already has Apache2, PHP, MySQL, and Composer installed
(as confirmed via `systemctl is-active apache2/mysql`, `php -v`, `composer
--version`), skip straight to **section 6 (Deploy the code)**, but use the
**Apache virtual host** in section 7b instead of the Nginx one, since Apache
is already your running web server.

## 3. Provision the AWS server (EC2)

1. Launch an EC2 instance — **Ubuntu 24.04 LTS**, `t3.small` or larger
   (staffing sites with an admin panel are not heavy; `t3.micro` works for
   testing, `t3.small`/`t3.medium` is safer for production).
2. Security group inbound rules: `22` (SSH, restrict to your IP), `80` (HTTP),
   `443` (HTTPS).
3. Allocate an Elastic IP and associate it with the instance (so the IP
   doesn't change on reboot).
4. Point your domain's `A` record at the Elastic IP (or use the IP directly
   for initial testing).

---

## 4. Install the server stack

SSH into the instance, then:

```bash
sudo apt update && sudo apt upgrade -y

# PHP 8.4 + extensions
sudo apt install -y software-properties-common
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update
sudo apt install -y php8.4-fpm php8.4-cli php8.4-mysql php8.4-mbstring \
  php8.4-xml php8.4-curl php8.4-zip php8.4-gd php8.4-bcmath php8.4-intl \
  php8.4-common unzip git nginx mysql-server

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Node 20 LTS (for building CSS/JS assets)
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

---

## 5. Set up MySQL

```bash
sudo mysql -e "CREATE DATABASE unitesystems CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER 'unitesystems'@'localhost' IDENTIFIED BY 'CHOOSE_A_STRONG_PASSWORD';"
sudo mysql -e "GRANT ALL PRIVILEGES ON unitesystems.* TO 'unitesystems'@'localhost'; FLUSH PRIVILEGES;"
```

---

## 6. Deploy the code

```bash
sudo mkdir -p /var/www/unitesystems
sudo chown $USER:$USER /var/www/unitesystems
git clone https://github.com/unitesystems-debug/unitesystemsite.git /var/www/unitesystems
cd /var/www/unitesystems

composer install --no-dev --optimize-autoloader
npm ci
npm run build

cp .env.example .env
php artisan key:generate
```

Edit `.env` with production values:

```
APP_NAME="Unite Systems"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unitesystems
DB_USERNAME=unitesystems
DB_PASSWORD=CHOOSE_A_STRONG_PASSWORD

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public

# Gmail SMTP — use a Gmail App Password (not your normal password):
# https://myaccount.google.com/apppasswords
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail-address@gmail.com
MAIL_PASSWORD="your-16-char-app-password"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-gmail-address@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
NOTIFY_EMAIL=your-gmail-address@gmail.com
```

Run migrations, then import the sample content and create the storage symlink:

```bash
php artisan migrate --force
mysql -u unitesystems -p unitesystems < database/seed-data/content-seed.sql
php artisan storage:link
```

Create your real admin login (do **not** reuse the local dev account):

```bash
php artisan make:filament-user
```

Set file permissions so the web server can write logs/cache/uploads:

```bash
sudo chown -R www-data:www-data /var/www/unitesystems
sudo find /var/www/unitesystems -type d -exec chmod 755 {} \;
sudo find /var/www/unitesystems -type f -exec chmod 644 {} \;
sudo chmod -R 775 /var/www/unitesystems/storage /var/www/unitesystems/bootstrap/cache
```

Cache config/routes/views for production performance:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 7. Nginx virtual host

Create `/etc/nginx/sites-available/unitesystems`:

```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/unitesystems/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    client_max_body_size 20M;
}
```

Enable it and reload:

```bash
sudo ln -s /etc/nginx/sites-available/unitesystems /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 7b. Apache virtual host (use this instead if Apache2 is already your web server)

Enable the required modules first:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Create `/etc/apache2/sites-available/unitesystems.conf`:

```apache
<VirtualHost *:80>
    ServerName your-domain-or-public-ip
    DocumentRoot /var/www/unitesystems/public

    <Directory /var/www/unitesystems/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/unitesystems-error.log
    CustomLog ${APACHE_LOG_DIR}/unitesystems-access.log combined
</VirtualHost>
```

Enable it and disable the default site:

```bash
sudo a2ensite unitesystems.conf
sudo a2dissite 000-default.conf
sudo apache2ctl configtest
sudo systemctl reload apache2
```

---

## 8. HTTPS (Let's Encrypt)

Only needed once you have a real domain pointed at the server (a bare IP
address cannot get a certificate).

**Nginx:**
```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d your-domain.com -d www.your-domain.com
```

**Apache:**
```bash
sudo apt install -y certbot python3-certbot-apache
sudo certbot --apache -d your-domain.com -d www.your-domain.com
```

Certbot auto-configures the HTTPS server block and sets up renewal.

---

## 9. Cron (scheduler)

Laravel's scheduler needs a single cron entry:

```bash
sudo crontab -e -u www-data
```

Add:

```
* * * * * cd /var/www/unitesystems && php artisan schedule:run >> /dev/null 2>&1
```

(Not currently used by any scheduled jobs in this app, but safe to add for
future features like cleaning up stale `livewire-tmp` files or queued digest
emails.)

---

## 10. Verify

```bash
curl -I https://your-domain.com/
curl -I https://your-domain.com/jobs
```

Then log into `/admin` with the account created in step 6 and confirm the
homepage content, jobs, and logo/hero image all match your local site.

---

## 11. Redeploying after future changes

```bash
cd /var/www/unitesystems
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
sudo systemctl reload php8.4-fpm
```

A ready-to-use version of this is in `deploy/deploy.sh`, and a GitHub Actions
template that runs it over SSH on every push to `main` is in
`.github/workflows/deploy.yml` (needs `HOST`, `USERNAME`, `SSH_KEY`, and
`DEPLOY_PATH` repository secrets to activate).
