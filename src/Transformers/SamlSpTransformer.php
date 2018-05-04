<?php

namespace HiHaHo\Saml\Transformers;

use HiHaHo\Saml\Models\SamlConfig;
use HiHaHo\Saml\Transformers\Traits\UsesCertificates;
use HiHaHo\Saml\Transformers\Traits\UsesPrivateKeys;
use League\Fractal\TransformerAbstract;

class SamlSpTransformer extends TransformerAbstract
{
    use UsesCertificates, UsesPrivateKeys {
        UsesCertificates::extractOpensslString insteadof UsesPrivateKeys;
    }

    protected $samlConfig;

    public function transform(SamlConfig $samlConfig)
    {
        $this->samlConfig = $samlConfig;
        $certificate = optional($this->samlConfig)->sp_x509_cert ?: config('saml-dsp.sp.x509cert');
        $privateKey = optional($this->samlConfig)->sp_private_key ?: config('saml-dsp.sp.privateKey');

        return [
            'NameIDFormat' => optional($samlConfig)->sp_name_id_format ?: config('saml-dsp.sp.NameIDFormat'),
            'x509cert' =>  $this->getCert($certificate),
            'privateKey' =>  $this->getPrivateKey($privateKey),
            'entityId' => $this->getEntityId(),
            'assertionConsumerService' => [
                'url' => optional($samlConfig)->sp_assertion_consumer_service_url ?? route('saml.acs', $samlConfig),
            ],
            'singleLogoutService' => [
                'url' => optional($samlConfig)->sp_single_logout_service_url ?? route('saml.sls', $samlConfig)
            ],
        ];
    }

    protected function getEntityId()
    {
        return optional($this->samlConfig)->sp_entity_id ?? route('saml.metadata', $this->samlConfig);
    }
}
