<?php

namespace HiHaHo\Saml;

use HiHaHo\Saml\Models\SamlUser;
use Illuminate\Http\Request;

class Saml
{
    /**
     * @var \OneLogin_Saml2_Auth
     */
    protected $oneLoginAuth;

    protected $samlConfig;

    public function __construct(\OneLogin_Saml2_Auth $auth = null, Request $request)
    {
        $this->samlConfig = app()->make('samlConfigTransformed');
        $this->oneLoginAuth = $auth;
    }

    public function isOneLoginSet()
    {
        return isset($this->oneLoginAuth);
    }

    /**
     * Show metadata about the local sp. Use this to configure your saml2 IDP
     * @return mixed xml string representing metadata
     * @throws \InvalidArgumentException if metadata is not correctly set
     */
    public function getMetadata()
    {
        $settings = $this->oneLoginAuth->getSettings();
        $metadata = $settings->getSPMetadata();
        $errors = $settings->validateMetadata($metadata);

        if (!empty($errors)) {
            throw new \InvalidArgumentException(
                'Invalid SP metadata: ' . implode(', ', $errors),
                \OneLogin_Saml2_Error::METADATA_SP_INVALID
            );
        }

        return $metadata;
    }

    /**
     * The user info from the assertion
     * @return SamlUser
     */
    public function getSaml2User()
    {
        return new SamlUser($this->oneLoginAuth);
    }

    public function loginUrl($returnTo = null, $parameters = [], $forceAuthn = false, $isPassive = false, $stay = true, $setNameIdPolicy = true)
    {
        return $this->login($returnTo, $parameters, $forceAuthn, $isPassive, $stay, $setNameIdPolicy);
    }

    public function login($returnTo = null, $parameters = array(), $forceAuthn = false, $isPassive = false, $stay = false, $setNameIdPolicy = true)
    {
        return $this->oneLoginAuth->login($returnTo, $parameters, $forceAuthn, $isPassive, $stay, $setNameIdPolicy);
    }

    /**
     * Initiate a saml2 logout flow. It will close session on all other SSO services. You should close
     * local session if applicable.
     *
     * @param string|null $returnTo            The target URL the user should be returned to after logout.
     * @param string|null $nameId              The NameID that will be set in the LogoutRequest.
     * @param string|null $sessionIndex        The SessionIndex (taken from the SAML Response in the SSO process).
     * @param string|null $nameIdFormat        The NameID Format will be set in the LogoutRequest.
     *
     * @return string|null If $stay is True, it return a string with the SLO URL + LogoutRequest + parameters
     *
     * @throws OneLogin_Saml2_Error
     */
    public function logout($returnTo = null, $nameId = null, $sessionIndex = null, $nameIdFormat = null)
    {
        $this->oneLoginAuth->logout($returnTo, [], $nameId, $sessionIndex, false, $nameIdFormat);
    }

    /**
     * Process a Saml response (assertion consumer service)
     * When errors are encountered, it returns an array with proper description
     */
    public function acs()
    {
        /** @var $auth OneLogin_Saml2_Auth */
        $auth = $this->oneLoginAuth;
        $auth->processResponse();
        $errors = $auth->getErrors();
        if (!empty($errors)) {
            return $errors;
        }
        if (!$auth->isAuthenticated()) {
            return array('error' => 'Could not authenticate');
        }
        return null;
    }

    /**
     * Process a Saml response (assertion consumer service)
     * returns an array with errors if it can not logout
     */
    public function sls($retrieveParametersFromServer = false)
    {
        $auth = $this->oneLoginAuth;
        // destroy the local session by firing the Logout event
        $keep_local_session = false;
        $session_callback = function () {
//            event(new Saml2LogoutEvent());
        };
        $auth->processSLO($keep_local_session, null, $retrieveParametersFromServer, $session_callback);
        $errors = $auth->getErrors();
        return $errors;
    }

    /**
     * Get the last error reason from \OneLogin_Saml2_Auth, useful for error debugging.
     * @see \OneLogin_Saml2_Auth::getLastErrorReason()
     * @return string
     */
    public function getLastErrorReason() {
        return $this->oneLoginAuth->getLastErrorReason();
    }
}
