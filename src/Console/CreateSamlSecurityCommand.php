<?php

namespace HiHaHo\Saml\Console;

use HiHaHo\Saml\Enums\DigestAlgorithm;
use HiHaHo\Saml\Enums\SignatureAlgoritm;
use HiHaHo\Saml\Models\SamlConfig;
use HiHaHo\Saml\Models\SamlSecurity;
use HiHaHo\Saml\Traits\SamlSecurityValidator;
use Illuminate\Console\Command;

class CreateSamlSecurityCommand extends Command
{
    use SamlSecurityValidator, ConsoleValidator;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saml:create-security {samlConfig : The saml configuration id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or chang';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $samlConfig = SamlConfig::find($this->argument('samlConfig'));

        if (!isset($samlConfig)) {
            $this->error('SAML config not found!');
            return;
        }

        $samlConfig->security->name_id_encrypted = $this->confirm('Name ID encrypted', $samlConfig->security->name_id_encrypted ?? config('saml-dsp.security.nameIdEncrypted'));
        $samlConfig->security->authn_requests_signed = $this->confirm('Authn request signed', $samlConfig->security->authn_requests_signed ?? config('saml-dsp.security.authnRequestSigned'));
        $samlConfig->security->logout_request_signed = $this->confirm('Logout request signed', $samlConfig->security->logout_request_signed ?? config('saml-dsp.security.logoutRequestSigned'));
        $samlConfig->security->logout_response_signed = $this->confirm('Logout response signed', $samlConfig->security->logout_response_signed ?? config('saml-dsp.security.logoutResponseSigned'));
        $samlConfig->security->sign_metadata = $this->confirm('Sign metadata', $samlConfig->security->sign_metadata ?? config('saml-dsp.security.signMetadata'));
        //TODO
        $samlConfig->security->sign_metadata_key_file_name = '{}';
        $samlConfig->security->want_messages_signed = $this->confirm('Want messages signed', $samlConfig->security->want_messages_signed ?? config('saml-dsp.security.wantMessagesSigned'));
        $samlConfig->security->want_assertions_encrypted = $this->confirm('Want assertions encrypted', $samlConfig->security->want_assertions_encrypted ?? config('saml-dsp.security.wantAssertionsEncrypted'));
        $samlConfig->security->want_assertions_signed = $this->confirm('Want assertions signed', $samlConfig->security->want_assertions_signed ?? config('saml-dsp.security.wantAssertionsSigned'));
        $samlConfig->security->want_name_id = $this->confirm('Want name ID', $samlConfig->security->want_name_id ?? config('saml-dsp.security.wantNameId'));
        $samlConfig->security->want_name_id_encrypted = $this->confirm('Want name ID encrypted', $samlConfig->security->want_name_id_encrypted ?? config('saml-dsp.security.wantNameIdEncrypted'));
        $samlConfig->security->requested_authn_context = $this->confirm('Request Authn context', $samlConfig->security->requested_authn_context ?? config('saml-dsp.security.requestedAuthnContext'));
        $samlConfig->security->want_XML_validation = $this->confirm('Want XML validation', $samlConfig->security->want_XML_validation ?? config('saml-dsp.security.wantXMLValidation'));
        $samlConfig->security->relax_destination_validation = $this->confirm('Relax destination validation', $samlConfig->security->relax_destination_validation ?? config('saml-dsp.security.relaxDestinationValidation'));

        $signatureOptions = [
            SignatureAlgoritm::RSA_SHA1,
            SignatureAlgoritm::DSA_SHA1,
            SignatureAlgoritm::RSA_SHA256,
            SignatureAlgoritm::RSA_SHA384,
            SignatureAlgoritm::RSA_SHA512,
        ];
        $samlConfig->security->signature_algorithm = $this->choice('Signature algorithm', $signatureOptions, array_search($samlConfig->security->signature_algorithm ?? config('saml-dsp.security.signatureAlgorithm'), $signatureOptions));

        $digestOptions = [
            DigestAlgorithm::SHA1,
            DigestAlgorithm::SHA256,
            DigestAlgorithm::SHA384,
            DigestAlgorithm::SHA512,
        ];
        $samlConfig->security->digest_algorithm = $this->choice('Digest algorithm', $digestOptions, array_search($samlConfig->security->digest_algorithm ?? config('saml-dsp.security.digestAlgorithm'), $digestOptions));

        $samlConfig->security->lowercase_urlencoding = $this->confirm('Lowercase URL encoding', $samlConfig->security->lowercase_urlencoding ?? config('saml-dsp.security.lowercaseUrlencoding'));

        $samlConfig->security->save();
    }
}
