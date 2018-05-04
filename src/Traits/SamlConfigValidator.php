<?php

namespace HiHaHo\Saml\Traits;

trait SamlConfigValidator
{
    public function rules()
    {
        return [
            'name' => 'string',
            'slug' => 'string|unique:saml_configs,slug',
            'login_handler' => 'nullable|string',
            'idp_base_url' => 'nullable|url',
            'idp_entity_id' => 'required|string',
            'idp_sso_url' => 'required|string',
            'idp_sso_binding' => 'required|string',
            'idp_slo_url' => 'required|string',
            'idp_slo_binding' => 'required|string',
            'idp_x509_cert' => 'nullable|string',
            'idp_cert_fingerprint' => 'string|nullable',
        ];
    }
}
