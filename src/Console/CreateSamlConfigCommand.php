<?php

namespace HiHaHo\Saml\Console;

use HiHaHo\Saml\Models\SamlConfig;
use HiHaHo\Saml\Models\SamlSecurity;
use HiHaHo\Saml\Traits\SamlConfigValidator;
use Illuminate\Console\Command;

class CreateSamlConfigCommand extends Command
{
    use SamlConfigValidator, ConsoleValidator;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saml:create-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new SAML configuration';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $samlConfig = new SamlConfig();

        $samlConfig->name = $this->askValidated('name', 'Name');
        $samlConfig->slug = str_slug($this->askValidated('slug', 'Slug', str_slug($samlConfig->name)));
        $samlConfig->login_handler = $this->askValidated('login_handler', 'Login handler class (e.g. \App\Http\Saml\Handlers\SurfConnextHandler or saml.handlers.surfconnext)', null);
        $samlConfig->idp_base_url = $this->askValidated('idp_base_url', 'IdP Base URL (e.g. https://example.com/idp)', null);
        $samlConfig->idp_entity_id = $this->askValidated('idp_entity_id', 'IdP Entity ID (e.g. /metadata or https://example.com/idp/metadata)', '/metadata');
        $samlConfig->idp_sso_url = $this->askValidated('idp_sso_url', 'IdP SSO URL (e.g. /login or https://example.com/idp/login)', '/login');
        $samlConfig->idp_sso_binding = $this->askValidated('idp_sso_binding', 'IdP SSO binding', 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect');
        $samlConfig->idp_slo_url = $this->askValidated('idp_slo_url', 'IdP SLO URL (e.g. /logout or https://example.com/idp/logout)', '/logout');
        $samlConfig->idp_slo_binding = $this->askValidated('idp_slo_binding', 'IdP SLO binding', 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect');
        $samlConfig->idp_x509_cert = $this->askValidated('idp_x509_cert', 'Public x509 certificate of the IdP', null);
        $samlConfig->idp_cert_fingerprint = $this->askValidated('idp_cert_fingerprint', 'Fingerprint of the public x509 certificate (required if idp_x509_cert is null)', null);

        $samlConfig->save();

        if ($this->confirm('Do you wish to change the default security parameters?')) {
            $samlSecurity = $this->createSamlSecurity();
            $samlConfig->security()->save($samlSecurity);
            $samlSecurity->save();
        }
    }

    /**
     * @return SamlSecurity
     */
    protected function createSamlSecurity()
    {
        return new SamlSecurity();
    }
}
