<?php

namespace HiHaHo\Saml\Http\Controllers;

use HiHaHo\Saml\Events\LoginEvent;
use HiHaHo\Saml\Http\Traits\LoginHandler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SamlController extends SamlBaseController
{
    use LoginHandler;

    public function base()
    {
        return redirect()->route('saml.login', $this->samlConfig);
    }

    public function metadata()
    {
        $metadata = $this->saml->getMetadata();

        return response($metadata, 200, ['Content-Type' => 'text/xml']);
    }

    public function login()
    {
        $url = $this->saml->loginUrl('/login');

        return redirect()->to($url);
    }

    public function logout(Request $request)
    {
        $returnTo = $request->query('returnTo');
        $sessionIndex = $request->query('sessionIndex');
        $nameId = $request->query('nameId');
        $this->saml->logout($returnTo, $nameId, $sessionIndex);
    }

    public function acs()
    {
        $errors = $this->saml->acs();
        if (!empty($errors)) {
            logger()->error('Saml2 error_detail', ['error' => $this->saml->getLastErrorReason()]);
            session()->flash('saml2_error_detail', [$this->saml->getLastErrorReason()]);
            logger()->error('Saml2 error', $errors);
            session()->flash('saml2_error', $errors);
            return redirect(config('saml2_settings.errorRoute'));
        }
        $user = $this->saml->getSaml2User();

        event(new LoginEvent($user, $this->saml, $this->samlConfig));

        $response = $this->handleLogin($user);

        if ($response instanceof Response || $response instanceof  RedirectResponse) {
            return $response;
        }

        $redirectUrl = $user->getIntendedUrl();
        if ($redirectUrl === null) {
            return redirect(config('saml2_settings.loginRoute'));
        }

        return redirect($redirectUrl);
    }

    public function sls()
    {
        $error = $this->saml->sls(config('saml2_settings.retrieveParametersFromServer'));
        if (!empty($error)) {
            throw new \Exception("Could not log out");
        }
        return redirect(config('saml2_settings.logoutRoute')); //may be set a configurable default
    }
}
