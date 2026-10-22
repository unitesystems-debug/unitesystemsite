# Unite Systems — Healthcare Staffing Website (Laravel)

A full Laravel rebuild of the Unite Systems LLC website: public marketing site, job board with
applications, candidate accounts, and a complete admin panel (built with [Filament](https://filamentphp.com))
for managing **every piece of content, every image, and all hiring data** — no code changes required.

> **Deploying to GitHub + AWS?** See [DEPLOYMENT.md](DEPLOYMENT.md) for the full
> step-by-step guide, including how to bring over the current sample content
> (homepage copy, job postings, logo/hero images).

## Stack

- **Laravel 12** (PHP 8.2+)
- **Filament 5** admin panel at `/admin`
- **SQLite** by default (zero config — see "Switching to MySQL" below)
- **Tailwind CSS v4** + Alpine.js for the public site (brand colors in `resources/css/app.css`)
- Laravel **Mail** (Gmail SMTP recommended) with every outgoing email logged to the admin **Email Outbox**

## What's included

**Public site:** Home, About, Services, Jobs (list + detail + apply), candidate Register/Login/My Account,
Contact, Privacy Policy, plus a lightweight chat widget that answers from your jobs & FAQ content.

**Admin panel (`/admin`):**
- **Dashboard** — open jobs, new applications, candidates, unread enquiries at a glance
- **Website Content**
  - *Page Text & Images* — every heading, paragraph, button label, and image on the site, grouped by page
  - *Content Blocks* — all repeatable sections (trust badges, challenges, solutions, FAQs, testimonials,
    industries, specialties, footer columns, navigation, etc.) — add, edit, reorder, delete
  - *Media Library* — upload/replace images used anywhere on the site
- **Hiring**
  - *Job Postings* — full CRUD with rich description, requirements/benefits lists, status & featured flag
  - *Applications* — review, change status, download resumes, CSV-friendly table
  - *Contact Messages* — every enquiry from the Contact page
  - *Candidates* — every registered candidate profile + resume download
- **System** — Admin Users, Email Outbox (every sent/failed email), Site Settings (company info, logo,
  favicon, social links, notification email, chat widget toggle)

## Getting started

```bash
composer install
npm install && npm run build      # or `npm run dev` while developing
cp .env.example .env              # already done in this repo — just review it
php artisan key:generate          # already set, skip if APP_KEY exists
php artisan migrate --seed        # creates the database and demo content/jobs/admin user
php artisan storage:link
php artisan serve                 # http://127.0.0.1:8000
```

### Default admin login

- URL: `/admin`
- Email: `admin@unitesystemsllc.com`
- Password: `Password123!`

**Change this password immediately** (Admin → System → Admin Users), and update the seeded user's
email in `database/seeders/AdminUserSeeder.php` if you reseed later.

## Configuring email (Gmail)

By default `MAIL_MAILER=log` so the app works immediately — emails are written to
`storage/logs/laravel.log` and always recorded in **Admin → Email Outbox**, so nothing breaks before
you configure real email.

To send real emails through Gmail:

1. Turn on 2-Step Verification on the Gmail account you want to send from.
2. Create an **App Password**: Google Account → Security → 2-Step Verification → App passwords.
3. Edit `.env`:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-gmail-address@gmail.com
   MAIL_PASSWORD="xxxx xxxx xxxx xxxx"   # the 16-character App Password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="your-gmail-address@gmail.com"
   MAIL_FROM_NAME="${APP_NAME}"
   ```
4. Run `php artisan config:clear`.
5. Set who receives new-application/contact/registration notifications in **Admin → Site Settings →
   Notification email(s)**.

Every email the app sends (notifications to you, confirmation emails to candidates) is logged — success
or failure — in **Admin → Email Outbox**, so you can always see what was sent and troubleshoot delivery.

## Local domain (Laragon)

`http://unitesystems.test` (and `https://unitesystems.test`) is already set up and working, the same way
`globalhireforyou.test` is:
- `C:\laragon\etc\apache2\sites-enabled\auto.unitesystems.test.conf` — Apache vhost pointing to this
  project's `public/` folder.
- `C:\Windows\System32\drivers\etc\hosts` — `127.0.0.1 unitesystems.test` entry.
- `APP_URL` in `.env` is set to `http://unitesystems.test`.

Just open **http://unitesystems.test/** in your browser — no further setup needed. If you ever move the
project folder, re-run Laragon's own "Apache/Nginx → Auto Virtual Hosts" (or edit the `.conf` file above)
and restart Apache from the Laragon tray icon.

### Important: file uploads under Laragon's Apache (Windows)

Laragon's Apache runs PHP via FastCGI (`php-cgi.exe`), and on this machine the default upload temp
directory (`C:\Windows\Temp`) caused uploads through the admin panel (logos, media, resumes) to fail with
a "Path must not be empty" error — likely Windows UAC virtualization interfering with that system folder.

**Fix already applied:** `upload_tmp_dir` in
`C:\laragon\bin\php\php-8.4.12-nts-Win32-vs17-x64\php.ini` now points to `C:\laragon\tmp` (created
automatically) instead of the Windows temp folder. This is a machine/PHP-install-level setting (it also
benefits other Laragon PHP sites) — if you ever reinstall/upgrade Laragon's PHP version, re-apply it:
```ini
upload_tmp_dir = "C:\laragon\tmp"
```
then restart Apache. If uploads ever fail again in the admin panel, this is the first thing to check.

## Branding

The official Unite Systems logo is uploaded via **Admin → Site Settings → Branding** (Logo + Favicon),
stored on the `public` disk at `storage/app/public/branding/`. The header/footer automatically show the
uploaded logo image instead of the text fallback once one is set.

The site's color theme (`resources/css/app.css`) was matched exactly to the logo's colors — **red
`#EC3A2E` and navy `#0E3057`** — by sampling the source logo file. The logo has no blue in it, so the
former blue accent (`--color-brand-blue` / `--color-brand-blue-deep`, used by primary buttons, links and
icon highlights) was re-pointed to the same red as `--color-brand-red` / `--color-brand-red-deep`, and the
pale "blue wash" background tints (`--color-ice`, `--color-blue-wash`, `--color-blue-tint`,
`--color-blue-line`) were converted to neutral light grays. This means every primary button, link, and
accent across the whole public site is red/navy only, with no blue remaining — no template files needed
to change, since all of them share these same CSS custom properties. Run `npm run build` after changing
theme colors.

## Design system (headings, eyebrows, scroll animation)

- **Serif headings** — major section titles use a `Lora` serif (`font-serif`, loaded from Google Fonts in
  `layouts/app.blade.php`) paired with the sans-serif body copy, matching the editorial look of the design
  reference. Applied to `h1`/`h2` across the home, about, services, jobs and contact pages.
- **Eyebrow labels** — the small red dash + uppercase label above section headings (e.g. "— The challenge")
  is the `<x-eyebrow>` Blade component (`resources/views/components/eyebrow.blade.php`); pass
  `align="center"` to center it.
- **Scroll-reveal animation** — add a `data-animate` attribute (optionally with
  `style="--animate-delay: 0.1s"` for staggering) to any element to make it fade + rise into view once when
  scrolled into the viewport. Powered by a small `IntersectionObserver` in `resources/js/app.js` plus the
  `[data-animate]` / `.in-view` CSS in `resources/css/app.css`; respects `prefers-reduced-motion`.
- **Home page sections** — the trust-badge bar, the "How Unite Systems works" process steps (with a
  red → navy → red gradient connector line), the "Human expertise. Smarter workforce technology." hub
  diagram (left = professionals, right = organizations, center = the Unite Systems "People + platform"
  card), and the testimonials carousel (Alpine.js-powered prev/next + dot navigation, registered as
  `testimonialCarousel` in `app.js`) were rebuilt to match the design reference, recolored to the logo's
  red/navy palette (the reference's blue accents were intentionally not used).
- The "Human expertise" section's copy and the professional/organization/hub-feature lists are editable in
  **Admin → Content Blocks** under the `home_humantech_*` groups, and its heading text in **Admin → Page
  Text & Images** under `home.humantech_*` keys (seeded by `database/seeders/HumanTechSeeder.php`, which is
  safe to re-run — it only touches those specific keys/groups and never other page content).

## Database

This app uses **MySQL** on the same local Laragon MySQL server as your other projects (e.g.
`globalhireforyou`), in a dedicated `unitesystems` database. `.env` is already configured:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unitesystems
DB_USERNAME=root
DB_PASSWORD=
```

If your MySQL root user needs a password, add it to `DB_PASSWORD` (quote it if it contains special
characters) and run `php artisan config:clear`. In this environment, `root@127.0.0.1` connects without a
password even though `root@localhost` may require one — if you see an "Access denied" error, set the
password that works for your MySQL client.

To (re)create the schema and demo content: `php artisan migrate:fresh --seed`.

A `database/database.sqlite` file is still present as a fallback — switch `DB_CONNECTION` back to
`sqlite` (and clear the other `DB_*` lines) if you ever want a zero-config local database instead.

## Content & data model

- `jobs` are stored in `job_postings` (Laravel's queue system already uses a table named `jobs`).
- `content_texts` holds every scalar text/image field on the site (grouped by page, e.g. `home.hero_title`).
- `content_items` holds every repeatable list (trust badges, FAQs, testimonials, specialties, footer
  columns, navigation links, etc.) — one flexible table, filterable by group in the admin, so you can add
  or remove items freely without touching code.
- `job_applications`, `candidate_profiles`, `contact_messages`, `media`, `settings`, `email_logs` cover
  hiring, candidate accounts, enquiries, the media library, site settings and the email outbox respectively.

Resumes are stored privately (`storage/app/private/resumes`) and can only be downloaded by the candidate
themselves or an admin, via signed, authenticated routes — never directly from `public/`.

## Useful commands

```bash
php artisan migrate:fresh --seed   # reset the database back to the seeded demo content
php artisan tinker                 # inspect/modify data from the CLI
npm run dev                        # Vite dev server with hot reload for the public site
```

## Project structure highlights

- `app/Filament/Resources` — all admin CRUD screens
- `app/Filament/Pages/ManageSettings.php` — the Site Settings page
- `app/Http/Controllers` — public site controllers (Home, Page, Job, Contact, Account, Chat, Auth)
- `app/Services/Notifier.php` — sends + logs every outgoing email
- `app/Services/ResumeUploader.php` — handles private resume uploads
- `resources/views/layouts/app.blade.php` — shared header/footer, pulls nav/footer/company info from the DB
- `resources/views/pages` & `resources/views/jobs` — public page templates
- `database/seeders` — demo admin user, settings, full site copy, and sample job postings
