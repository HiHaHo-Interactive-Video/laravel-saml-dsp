<?php

namespace HiHaHo\Saml\Console;

use HiHaHo\Saml\Models\SamlConfig;
use HiHaHo\Saml\Models\SamlSecurity;
use HiHaHo\Saml\Traits\SamlConfigValidator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CreateSamlConfigCommand extends Command
{
    use SamlConfigValidator, ConsoleValidator;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saml:create-config {samlConfig?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new SAML configuration';

    protected $samlConfig;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->samlConfig = $samlConfig = SamlConfig::find($this->argument('samlConfig'));

        if (!isset($samlConfig)) {
            $samlConfig = new SamlConfig();
        }

        $samlConfig->name = $this->askValidated('name', 'Name', $samlConfig->name);
        $samlConfig->slug = Str::slug($this->askValidated('slug', 'Slug', $samlConfig->slug ?? Str::slug($samlConfig->name)));
        $samlConfig->login_handler = $this->askValidated('login_handler', 'Login handler class (e.g. \App\Http\Saml\Handlers\SurfConnextHandler or saml.handlers.surfconnext)', $samlConfig->login_handler);
        $samlConfig->idp_base_url = $this->askValidated('idp_base_url', 'IdP Base URL (e.g. https://example.com/idp)', $samlConfig->idp_base_url);
        $samlConfig->idp_entity_id = $this->askValidated('idp_entity_id', 'IdP Entity ID (e.g. /metadata or https://example.com/idp/metadata)', $samlConfig->idp_entity_id ?? '/metadata');
        $samlConfig->idp_sso_url = $this->askValidated('idp_sso_url', 'IdP SSO URL (e.g. /login or https://example.com/idp/login)', $samlConfig->idp_sso_url ?? '/login');
        $samlConfig->idp_sso_binding = $this->askValidated('idp_sso_binding', 'IdP SSO binding', $samlConfig->idp_sso_binding ?? 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect');
        $samlConfig->idp_slo_url = $this->askValidated('idp_slo_url', 'IdP SLO URL (e.g. /logout or https://example.com/idp/logout)', $samlConfig->idp_slo_url ?? '/logout');
        $samlConfig->idp_slo_binding = $this->askValidated('idp_slo_binding', 'IdP SLO binding', $samlConfig->idp_slo_binding ?? 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect');
        $samlConfig->idp_x509_cert = $this->askValidated('idp_x509_cert', 'Public x509 certificate of the IdP', $samlConfig->idp_x509_cert);
        $samlConfig->idp_cert_fingerprint = $this->askValidated('idp_cert_fingerprint', 'Fingerprint of the public x509 certificate (required if idp_x509_cert is null)', $samlConfig->idp_cert_fingerprint);

        $samlConfig->save();

        $this->info('SAML config saved!');

        if ($this->confirm('Do you wish to change the default security parameters?')) {
            $this->call('saml:create-security', [
                'samlConfig' => $samlConfig->id,
            ]);
        }
    }
}
