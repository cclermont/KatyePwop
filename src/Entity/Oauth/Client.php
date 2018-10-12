<?php

namespace App\Entity\Oauth;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;

/**
 * @ORM\Table(name="oauth2_client", options={"collate"="utf8_unicode_ci", "charset"="utf8", "engine"="MyISAM"})
 * @ORM\Entity
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * Grant types support by draft 20
    */
    const GRANT_TYPE_IMPLICIT           = 'token';
    const GRANT_TYPE_USER_CREDENTIALS   = 'password';
    const GRANT_TYPE_EXTENSIONS         = 'extensions';
    const GRANT_TYPE_REFRESH_TOKEN      = 'refresh_token';
    const GRANT_TYPE_CLIENT_CREDENTIALS = 'client_credentials';
    const GRANT_TYPE_AUTH_CODE          = 'authorization_code';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
}