<?php

namespace TurboShip\Api\Requests;


use jamesvweston\Utilities\ArrayUtil AS AU;
use TurboShip\Api\Requests\Contracts\BaseRequestContract;

class CreateAccessTokenRequest implements BaseRequestContract
{

    /**
     * @var string
     */
    protected $client_id;

    /**
     * @var string
     */
    protected $client_secret;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $grant_type;

    /**
     * @var string
     */
    protected $scope;


    /**
     * AccessToken constructor.
     * @param array|null $data
     */
    public function __construct($data = null)
    {
        if (is_array($data))
        {
            $this->client_id                    = AU::get($data['client_id']);
            $this->client_secret                = AU::get($data['client_secret']);
            $this->grant_type                   = AU::get($data['grant_type']);
            $this->username                     = AU::get($data['username']);
            $this->password                     = AU::get($data['password']);
            $this->scope                        = AU::get($data['scope']);
        }
    }

    /**
     * @return array
     */
    public function getSerializedRequest()
    {
        return [
            [
                'name'     => 'client_id',
                'contents' => $this->client_id,
            ],
            [
                'name'     => 'client_secret',
                'contents' => $this->client_secret,
            ],
            [
                'name'     => 'username',
                'contents' => $this->username,
            ],
            [
                'name'     => 'password',
                'contents' => $this->password,
            ],
            [
                'name'     => 'grant_type',
                'contents' => $this->grant_type,
            ],
            [
                'name'     => 'scope',
                'contents' => $this->scope,
            ]
        ];
    }
    
    /**
     * @return string
     */
    public function getEndPoint()
    {
        return '/oauth/access_token';
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param string $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * @param string $client_secret
     */
    public function setClientSecret($client_secret)
    {
        $this->client_secret = $client_secret;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getGrantType()
    {
        return $this->grant_type;
    }

    /**
     * @param string $grant_type
     */
    public function setGrantType($grant_type)
    {
        $this->grant_type = $grant_type;
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }
    
}