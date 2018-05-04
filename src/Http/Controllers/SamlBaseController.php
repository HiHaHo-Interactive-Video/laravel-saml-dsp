<?php

namespace HiHaHo\Saml\Http\Controllers;

use HiHaHo\Saml\Models\SamlConfig;
use HiHaHo\Saml\Saml;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

abstract class SamlBaseController extends Controller
{
    /**
     * @var Saml
     */
    protected $saml;

    protected $samlConfig;

    public function __construct(Request $request, Saml $saml)
    {
        $this->saml = $saml;
        if (!app()->make('saml.database.exists')) {
            return $this->throwSamlConfigModelNotFoundException();
        }

        $this->samlConfig = SamlConfig::whereSlug($request->route('samlConfig'))->first();
        if (!isset($samlConfig)) {
            return $this->throwSamlConfigModelNotFoundException();
        }
    }

    private function throwSamlConfigModelNotFoundException()
    {
        if (app()->runningInConsole()) {
            return;
        }
        throw (new ModelNotFoundException)->setModel(SamlConfig::class);
    }
}
