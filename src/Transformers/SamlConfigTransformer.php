<?php

namespace HiHaHo\Saml\Transformers;

use HiHaHo\Saml\Models\SamlConfig;
use League\Fractal\TransformerAbstract;

class SamlConfigTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'idp',
        'sp',
        'security',
        'contactPerson',
        'organization',
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(SamlConfig $samlConfig)
    {
        return  [
            'routesPrefix' => $samlConfig->route_prefix,
            'loginRoute' => $samlConfig->login_route,
        ];
    }

    public function includeIdp(SamlConfig $samlConfig)
    {
        return $this->item($samlConfig, new SamlIdpTransformer());
    }

    public function includeSp(SamlConfig $samlConfig)
    {
        return $this->item($samlConfig, new SamlSpTransformer());
    }

    public function includeSecurity(SamlConfig $samlConfig)
    {
        return $this->item($samlConfig->security, new SamlSecurityTransformer());
    }

    public function includeContactPerson(SamlConfig $samlConfig)
    {
        return $this->item($samlConfig, new SamlContactPerson());
    }

    public function includeOrganization(SamlConfig $samlConfig)
    {
        return $this->item($samlConfig, new SamlOrganization());
    }
}
