<?php

namespace HiHaHo\Saml\Transformers;

use HiHaHo\Saml\Models\SamlConfig;
use League\Fractal\TransformerAbstract;

class SamlOrganization extends TransformerAbstract
{
    public function transform(SamlConfig $samlConfig)
    {
        $organizations = [];
        foreach (config('saml-dsp.organization') as $language => $organization) {
            $organizations[$language] = [
                'name' => array_get($organization, 'name', 'Unknown'),
                'displayname' => array_get($organization, 'displayname', 'Unknown'),
                'url' => array_get($organization, 'url', 'Unknown'),
            ];
        }
        return $organizations;
    }
}
