<?php

namespace HiHaHo\Saml\Transformers\Traits;

trait ExtractsOpensslString
{
    protected function extractOpensslString($keyString, $delimiter)
    {
        $keyString = str_replace(["\r", "\n"], "", $keyString);
        $regex = '/-{5}BEGIN(?:\s|\w)+' . $delimiter . '-{5}\s*(.+?)\s*-{5}END(?:\s|\w)+' . $delimiter . '-{5}/m';
        preg_match($regex, $keyString, $matches);
        return empty($matches[1]) ? '' : $matches[1];
    }
}
