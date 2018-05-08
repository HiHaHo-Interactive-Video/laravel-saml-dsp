<?php

namespace HiHaHo\Saml\Transformers\Traits;

use Illuminate\Support\Facades\File;

trait UsesPrivateKeys
{
    use ExtractsOpensslString;

    protected function getPrivateKey($privateKey)
    {
        if (!starts_with($privateKey, 'file://')) {
            return $privateKey;
        }

        $certPath = str_after($privateKey, 'file://');

        if (File::exists($certPath) && !File::isDirectory($certPath)) {
            return $this->extractPrivateKey($certPath);
        }

        if (File::exists(resource_path($certPath)) && !File::isDirectory(resource_path($certPath))) {
            return $this->extractPrivateKey(resource_path($certPath));
        }

        throw new \Exception('Could not read private key-file at path \'' . $certPath . '\'');
    }

    protected function extractPrivateKey($path)
    {
        $res = openssl_get_privatekey(File::get($path));
        if (empty($res)) {
            throw new \Exception('Could not read private key-file at path \'' . $path . '\'');
        }

        //TODO: Remove config
        if (!openssl_pkey_export($res, $pkey, null)) {
            throw new \Exception('Could not export private key-file at path \'' . $path . '\'');
        }

        openssl_pkey_free($res);
        return $this->extractOpensslString($pkey, 'PRIVATE KEY');
    }
}
