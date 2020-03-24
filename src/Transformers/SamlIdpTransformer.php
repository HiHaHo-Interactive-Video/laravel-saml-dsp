<?php

namespace HiHaHo\Saml\Transformers;

use HiHaHo\Saml\Models\SamlConfig;
use HiHaHo\Saml\Transformers\Traits\UsesCertificates;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class SamlIdpTransformer extends TransformerAbstract
{
    use UsesCertificates;

    public function transform(SamlConfig $samlConfig)
    {
        $certificate = optional($samlConfig)->idp_x509_cert ?: config('saml-dsp.idp.x509cert');

        return [
            'entityId' => $samlConfig->idp_entity_id,
            'singleSignOnService' => [
                'url' => $samlConfig->full_idp_sso_url,
                'binding' => $samlConfig->idp_sso_binding,
            ],
            'singleLogoutService' => [
                'url' => $samlConfig->full_idp_slo_url,
                'binding' => $samlConfig->idp_slo_binding,
            ],
            'x509cert' => $this->getCert($certificate),
            'certFingerprint' => $samlConfig->idp_certFingerprint,
        ];
    }

    private function getUrl(string $baseUrl = null, string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }

        if (Str::endsWith($baseUrl, '/')) {
            $baseUrl = Str::replaceLast('/', '', $baseUrl);
        }

        $urlWithBase = $baseUrl . Str::start($url, '/');

        if (!filter_var($urlWithBase, FILTER_VALIDATE_URL)) {
            throw new \Exception('No valid URL');
        }

        return $urlWithBase;
    }
}
