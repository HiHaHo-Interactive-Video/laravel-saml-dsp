<?php
/**
 * Created by PhpStorm.
 * User: Robert Boes
 * Date: 05-05-2018
 * Time: 12:03
 */

namespace HiHaHo\Saml\Enums;


class DigestAlgorithm extends BaseEnum
{
    const SHA1 = 'http://www.w3.org/2000/09/xmldsig#sha1';
    const SHA256 = 'http://www.w3.org/2001/04/xmlenc#sha256';
    const SHA384 = 'http://www.w3.org/2001/04/xmldsig-more#sha384';
    const SHA512 = 'http://www.w3.org/2001/04/xmlenc#sha512';
}
