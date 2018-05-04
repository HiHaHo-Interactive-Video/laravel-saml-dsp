<?php

namespace HiHaHo\Saml\Events;

use HiHaHo\Saml\Models\SamlConfig;
use HiHaHo\Saml\Models\SamlUser;
use HiHaHo\Saml\Saml;

class LoginEvent
{
    protected $user;
    protected $saml;
    protected $samlConfig;

    public function __construct(SamlUser $user, Saml $saml, SamlConfig $samlConfig)
    {
        $this->user = $user;
        $this->saml = $saml;
        $this->samlConfig = $samlConfig;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getSaml()
    {
        return $this->saml;
    }

    public function getConfig()
    {
        return $this->samlConfig;
    }
}
