<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSettings extends Page
{
    protected string $view = 'filament.pages.manage-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog;

    protected static string|UnitEnum|null $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?int $navigationSort = 4;

    protected static ?string $title = 'Site Settings';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'company_name' => Setting::get('company_name', 'Unite Systems'),
            'company_legal' => Setting::get('company_legal', 'Unite Systems LLC'),
            'company_phone' => Setting::get('company_phone', '855-792-1297'),
            'company_email' => Setting::get('company_email', 'info@unitesystemsllc.com'),
            'company_hq' => Setting::get('company_hq', 'Kentucky, USA'),
            'company_presence' => Setting::get('company_presence', 'USA and India'),
            'company_tagline' => Setting::get('company_tagline', 'Transforming healthcare through exceptional talent partnerships and innovative staffing solutions nationwide.'),
            'logo' => Setting::get('logo'),
            'favicon' => Setting::get('favicon'),
            'social_facebook' => Setting::get('social_facebook'),
            'social_linkedin' => Setting::get('social_linkedin'),
            'social_twitter' => Setting::get('social_twitter'),
            'social_instagram' => Setting::get('social_instagram'),
            'notify_email' => Setting::get('notify_email'),
            'candidate_confirmation' => Setting::get('candidate_confirmation', '1') === '1',
            'chat_enabled' => Setting::get('chat_enabled', '1') === '1',
            'chat_welcome' => Setting::get('chat_welcome', 'Hi! Ask me about our open jobs or services and I\'ll do my best to help.'),
            'footer_legal_text' => Setting::get('footer_legal_text', 'Equal Opportunity Employer.'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Company information')
                    ->columns(2)
                    ->components([
                        TextInput::make('company_name')->label('Display name')->required(),
                        TextInput::make('company_legal')->label('Legal name'),
                        TextInput::make('company_phone')->label('Phone number'),
                        TextInput::make('company_email')->label('Public email')->email(),
                        TextInput::make('company_hq')->label('Headquarters'),
                        TextInput::make('company_presence')->label('Presence / offices'),
                        Textarea::make('company_tagline')->label('Tagline')->rows(2)->columnSpanFull(),
                    ]),
                Section::make('Branding')
                    ->columns(2)
                    ->components([
                        FileUpload::make('logo')->image()->disk('public')->directory('branding'),
                        FileUpload::make('favicon')->image()->disk('public')->directory('branding'),
                    ]),
                Section::make('Social links')
                    ->columns(2)
                    ->components([
                        TextInput::make('social_facebook')->label('Facebook URL')->url(),
                        TextInput::make('social_linkedin')->label('LinkedIn URL')->url(),
                        TextInput::make('social_twitter')->label('X / Twitter URL')->url(),
                        TextInput::make('social_instagram')->label('Instagram URL')->url(),
                    ]),
                Section::make('Notifications & email')
                    ->description('New applications, registrations and enquiries are emailed here. Configure your Gmail SMTP credentials in the .env file.')
                    ->components([
                        TextInput::make('notify_email')
                            ->label('Notification email(s)')
                            ->helperText('Comma-separate multiple addresses.')
                            ->required(),
                        Toggle::make('candidate_confirmation')
                            ->label('Send candidates a confirmation email when they apply'),
                    ]),
                Section::make('Chat widget')
                    ->components([
                        Toggle::make('chat_enabled')->label('Show the chat widget on the public site'),
                        Textarea::make('chat_welcome')->label('Welcome message')->rows(2),
                    ]),
                Section::make('Footer')
                    ->components([
                        TextInput::make('footer_legal_text'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }

            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}
