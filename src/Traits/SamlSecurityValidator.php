<?php

namespace HiHaHo\Saml\Traits;

trait SamlSecurityValidator
{
    public function rules()
    {
        return [
            'name_id_encrypted' => 'boolean',
        ];
    }
}
