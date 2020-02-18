<?php

namespace HiHaHo\Saml\Transformers\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait UsesCertificates
{
    use ExtractsOpensslString;

    protected function getCert($certificate)
    {
        if (!Str::startsWith($certificate, 'file://')) {
            return $certificate;
        }

        $certPath = Str::after($certificate, 'file://');

        if (File::exists($certPath) && !File::isDirectory($certPath)) {
            return $this->extractCert($certPath);
        }

        if (File::exists(resource_path($certPath)) && !File::isDirectory(resource_path($certPath))) {
            return $this->extractCert(resource_path($certPath));
        }

        throw new \Exception('Could not read X509 certificate-file at path \'' . $certPath . '\'');
    }

    protected function extractCert($path)
    {
        $res = openssl_x509_read(File::get($path));
        if (empty($res)) {
            throw new \Exception('Could not read X509 certificate-file at path \'' . $path . '\'');
        }
        openssl_x509_export($res, $cert);
        openssl_x509_free($res);
        return $this->extractOpensslString($cert, 'CERTIFICATE');
    }
}
