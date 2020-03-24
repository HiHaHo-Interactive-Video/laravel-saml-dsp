<?php

namespace HiHaHo\Saml\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SamlConfig extends Model
{
    use SoftDeletes;

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function security()
    {
        return $this->hasOne(SamlSecurity::class)->withDefault();
    }

    public function getUrlWithBase($url)
    {
        if (!isset($this->full_idp_base_url)) {
            return $url;
        }

        return $this->full_idp_base_url . Str::start($url, '/');
    }

    public function getIdpEntityIdAttribute()
    {
        return $this->attributes['idp_entity_id'] ?? config('saml-dsp.idp.entityId');
    }

    public function getFullIdpEntityIdAttribute()
    {
        return $this->getUrlWithBase($this->idp_entity_id);
    }

    public function getFullIdpSsoUrlAttribute()
    {
        if (!isset($this->idp_sso_url)) {
            return config('saml-dsp.idp.singleSignOnService.url');
        }

        return $this->getUrlWithBase($this->idp_sso_url);
    }

    public function getFullIdpSloUrlAttribute()
    {
        if (!isset($this->idp_slo_url)) {
            return config('saml-dsp.idp.singleLogoutService.url');
        }

        return $this->getUrlWithBase($this->idp_slo_url);
    }

    public function getFullIdpBaseUrlAttribute()
    {
        if (!isset($this->idp_base_url)) {
            return null;
        }

        if (Str::endsWith($this->idp_base_url, '/')) {
            return Str::replaceLast('/', '', $this->idp_base_url);
        }

        return $this->idp_base_url;
    }
}
