<?php

namespace TurboShip\Api\Responses;


use jamesvweston\Utilities\ArrayUtil AS AU;

class CreateAccessTokenResponse
{

    /**
     * @var string
     */
    protected $access_token;

    /**
     * @var string
     */
    protected $token_type;

    /**
     * @var int
     */
    protected $expires_in;


    /**
     * AccessTokenResponse constructor.
     * @param array|null $data
     */
    public function __construct($data = null)
    {
        if (is_array($data))
        {
            $this->access_token                 = AU::get($data['access_token']);
            $this->token_type                   = AU::get($data['token_type']);
            $this->expires_in                   = AU::get($data['expires_in']);
        }
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->token_type;
    }

    /**
     * @param string $token_type
     */
    public function setTokenType($token_type)
    {
        $this->token_type = $token_type;
    }

    /**
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expires_in;
    }

    /**
     * @param int $expires_in
     */
    public function setExpiresIn($expires_in)
    {
        $this->expires_in = $expires_in;
    }
    
}