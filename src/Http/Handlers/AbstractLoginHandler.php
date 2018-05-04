<?php

namespace HiHaHo\Saml\Http\Handlers;

use HiHaHo\Saml\Models\SamlConfig;
use HiHaHo\Saml\Models\SamlUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

abstract class AbstractLoginHandler
{
    /**
     * @param SamlUser $user
     * @param SamlConfig $samlConfig
     * @return Response|RedirectResponse|void|null
     */
    abstract public function handle(SamlUser $user, SamlConfig $samlConfig);
}
