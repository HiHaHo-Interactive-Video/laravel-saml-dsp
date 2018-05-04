<?php

namespace HiHaHo\Saml\Transformers;

use HiHaHo\Saml\Models\SamlSecurity;
use League\Fractal\TransformerAbstract;

class SamlSecurityTransformer extends TransformerAbstract
{
    public function transform(SamlSecurity $samlSecurity)
    {
//        dd($samlSecurity);
        return [
            'nameIdEncrypted' => optional($samlSecurity)->name_id_encrypted ?? config('saml-dsp.security.nameIdEncrypted'),
            'authnRequestsSigned' => optional($samlSecurity)->authn_requests_signed ?? config('saml-dsp.security.authnRequestsSigned'),
            'logoutRequestSigned' => optional($samlSecurity)->logout_request_signed ?? config('saml-dsp.security.logoutRequestSigned'),
            'logoutResponseSigned' => optional($samlSecurity)->logout_response_signed ?? config('saml-dsp.security.logoutResponseSigned'),
            'signMetadata' => optional($samlSecurity)->sign_metadata ?? config('saml-dsp.security.signMetadata'),
            // 'sign_metadata_key_file_name'
            'wantMessagesSigned' => optional($samlSecurity)->want_messages_signed ?? config('saml-dsp.security.wantMessagesSigned'),
            'wantAssertionsEncrypted' => optional($samlSecurity)->want_assertions_encrypted ?? config('saml-dsp.security.wantAssertionsEncrypted'),
            'wantAssertionsSigned' => optional($samlSecurity)->want_assertions_signed ?? config('saml-dsp.security.wantAssertionsSigned'),
            'wantNameId' => optional($samlSecurity)->want_name_id ?? config('saml-dsp.security.wantNameId'),
            'wantNameIdEncrypted' => optional($samlSecurity)->want_name_id_encrypted ?? config('saml-dsp.security.wantNameIdEncrypted'),
            'requestedAuthnContext' => optional($samlSecurity)->requested_authn_context ?? config('saml-dsp.security.requestedAuthnContext'),
            'wantXMLValidation' => optional($samlSecurity)->want_XML_validation ?? config('saml-dsp.security.wantXMLValidation'),
//            'relaxDestinationValidation' => optional($samlSecurity)->relax_destination_validation ?? config('saml-dsp.security.relaxDestinationValidation'),
            'signatureAlgorithm' => optional($samlSecurity)->signature_algorithm ?? config('saml-dsp.security.signatureAlgorithm'),
            'digestAlgorithm' => optional($samlSecurity)->digest_algorithm ?? config('saml-dsp.security.digestAlgorithm'),
            'lowercaseUrlencoding' => optional($samlSecurity)->lowercase_urlencoding ?? config('saml-dsp.security.lowercaseUrlencoding'),
        ];
    }
}
