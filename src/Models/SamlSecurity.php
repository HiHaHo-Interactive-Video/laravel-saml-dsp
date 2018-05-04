<?php

namespace HiHaHo\Saml\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SamlSecurity extends Model
{
    use SoftDeletes;

    protected $table = 'saml_security';

    protected $casts = [
        'name_id_encrypted' => 'boolean',
        'authn_requests_signed' => 'boolean',
        'logout_request_signed' => 'boolean',
        'logout_response_signed' => 'boolean',
        'sign_metadata' => 'boolean',
        'want_messages_signed' => 'boolean',
        'want_assertions_encrypted' => 'boolean',
        'want_assertions_signed' => 'boolean',
        'want_name_id' => 'boolean',
        'want_name_id_encrypted' => 'boolean',
        'requested_authn_context' => 'boolean',
        'want_XML_validation' => 'boolean',
        'lowercase_urlencoding' => 'boolean',
    ];

    public function config()
    {
        return $this->belongsTo(SamlConfig::class);
    }
}
