<?php
/**
 * Created by PhpStorm.
 * User: Robert Boes
 * Date: 05-05-2018
 * Time: 11:55
 */

namespace HiHaHo\Saml\Enums;


class SignatureAlgoritm extends BaseEnum
{
    const RSA_SHA1 = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';
    const DSA_SHA1 = 'http://www.w3.org/2000/09/xmldsig#dsa-sha1';
    const RSA_SHA256 = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256';
    const RSA_SHA384 = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha384';
    const RSA_SHA512 = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha512';
}
