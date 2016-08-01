<?php

namespace TurboShip\Api\Configuration;


use jamesvweston\Utilities\ArrayUtil AS AU;
use TurboShip\Api\Contracts\ApiConfigurationContract;

class ApiConfiguration implements ApiConfigurationContract
{

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
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var string
     */
    protected $scope;

    /**
     * @var string
     */
    protected $grantType;
    
    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $authEndpoint;
    
    /**
     * @var string
     */
    protected $locationsEndPoint;

    /**
     * @var string
     */
    protected $postageEndPoint;

    /**
     * @var string
     */
    protected $defaultEndPoint;


    public function __construct($data = null)
    {
        $this->username             = AU::get($data['username']);
        $this->password             = AU::get($data['password']);
        $this->clientId             = AU::get($data['clientId']);
        $this->clientSecret         = AU::get($data['clientSecret']);
        $this->scope                = AU::get($data['scope']);
        $this->grantType            = AU::get($data['grantType'],           'password');
        $this->accessToken          = AU::get($data['accessToken']);
        $this->authEndpoint         = AU::get($data['authEndpoint'],        'https://auth.turboship.com');
        $this->locationsEndPoint    = AU::get($data['locationsEndPoint'],   'https://locations.turboship.com');
        $this->postageEndPoint      = AU::get($data['postageEndPoint'],     'https://postage.turboship.com');
        $this->defaultEndPoint      = AU::get($data['defaultEndPoint'],     $this->authEndpoint);
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
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
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

    /**
     * @return string
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    /**
     * @param string $grantType
     */
    public function setGrantType($grantType)
    {
        $this->grantType = $grantType;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getAuthEndpoint()
    {
        return $this->authEndpoint;
    }

    /**
     * @param string $authEndpoint
     */
    public function setAuthEndpoint($authEndpoint)
    {
        $this->authEndpoint = $authEndpoint;
    }

    /**
     * @return string
     */
    public function getLocationsEndPoint()
    {
        return $this->locationsEndPoint;
    }

    /**
     * @param string $locationsEndPoint
     */
    public function setLocationsEndPoint($locationsEndPoint)
    {
        $this->locationsEndPoint = $locationsEndPoint;
    }

    /**
     * @return string
     */
    public function getPostageEndPoint()
    {
        return $this->postageEndPoint;
    }

    /**
     * @param string $postageEndPoint
     */
    public function setPostageEndPoint($postageEndPoint)
    {
        $this->postageEndPoint = $postageEndPoint;
    }

    /**
     * @return string
     */
    public function getDefaultEndPoint()
    {
        return $this->defaultEndPoint;
    }

    /**
     * @param string $defaultEndPoint
     */
    public function setDefaultEndPoint($defaultEndPoint)
    {
        $this->defaultEndPoint = $defaultEndPoint;
    }
    
    
}