<?php

namespace HiHaHo\Saml\Transformers;

use HiHaHo\Saml\Models\SamlConfig;
use League\Fractal\TransformerAbstract;

class SamlContactPerson extends TransformerAbstract
{
    public function transform(SamlConfig $samlConfig)
    {
        $contactPersons = [];
        foreach (config('saml-dsp.contactPerson') as $contactType => $contactPerson) {
            $contactPersons[$contactType] = [
                'givenName' => array_get($contactPerson, 'givenName', 'Unknown'),
                'emailAddress' => array_get($contactPerson, 'emailAddress', 'Unknown'),
            ];
        }
        return $contactPersons;
    }
}
