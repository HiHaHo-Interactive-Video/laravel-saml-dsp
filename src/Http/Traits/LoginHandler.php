<?php

namespace HiHaHo\Saml\Http\Traits;

use HiHaHo\Saml\Http\Handlers\AbstractLoginHandler;
use HiHaHo\Saml\Models\SamlUser;

trait LoginHandler
{
    protected function handleLogin(SamlUser $user)
    {
        if (empty($this->samlConfig->login_handler)) {
            return;
        }

        $loginHandler = $this->getLoginHandler($this->samlConfig->login_handler);

        if (!is_subclass_of(get_class($loginHandler), AbstractLoginHandler::class)) {
            throw new \Exception('Class "'.get_class($loginHandler).'" must extend "'. AbstractLoginHandler::class .'" class');
        }

        return $loginHandler->handle($user, $this->samlConfig);
    }

    /**
     * @param $loginHandlerClass
     * @return AbstractLoginHandler|mixed
     * @throws \Exception
     */
    private function getLoginHandler($loginHandlerClass)
    {
        if (!class_exists($loginHandlerClass) && !app()->bound($loginHandlerClass)) {
            throw new \Exception('Login handler "'. $loginHandlerClass .'" was set but could not be found.');
        }

        return app()->make($loginHandlerClass);
    }
}
