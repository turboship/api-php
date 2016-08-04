<?php

namespace TurboShip\Api;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use jamesvweston\Utilities\ArrayUtil AS AU;
use TurboShip\Api\Configuration\ApiConfiguration;
use TurboShip\Api\Contracts\ApiConfigurationContract;
use TurboShip\Api\Exceptions\UnauthorizedClientException;
use TurboShip\Api\Http\HttpRequest;
use Dotenv\Dotenv;

class ApiClient
{

    /**
     * @var ApiConfiguration
     */
    protected $apiConfiguration;

    /**
     * @var HttpRequest
     */
    protected $httpRequest;

    /**
     * TurboShipAuthClient constructor.
     * @param ApiConfigurationContract|array|string|null    $apiConfiguration
     * @param Client|null   $guzzle
     */
    public function __construct($apiConfiguration = null, $guzzle = null)
    {
        $guzzle                 = !is_null($guzzle) ? $guzzle : new Client();
        $this->setApiConfiguration($apiConfiguration);
        
        $this->httpRequest      = new HttpRequest($guzzle, $this->apiConfiguration);
    }

    /**
     * @param       string          $url            The relative URL after the host name
     * @param       array|null      $queryString    Data to add as a queryString to the url
     * @return      mixed
     * @throws      ConnectException
     * @throws      RequestException
     * @throws      UnauthorizedClientException
     */
    public function get($url, $queryString = null)
    {
        return $this->tryRequest('get', $url, null, $queryString);
    }

    /**
     * @param       string          $url            The relative URL after the host name
     * @param       array|null      $payload        Contents of the body
     * @param       array|null      $queryString    Data to add as a queryString to the url
     * @return      mixed
     * @throws      ConnectException
     * @throws      RequestException
     * @throws      UnauthorizedClientException
     */
    public function post($url, $payload, $queryString = null)
    {
        return $this->tryRequest('post', $url, $payload, $queryString);
    }

    /**
     * @param       string          $url            The relative URL after the host name
     * @param       array|null      $payload        Contents of the body
     * @param       array|null      $queryString    Data to add as a queryString to the url
     * @return      mixed
     * @throws      ConnectException
     * @throws      RequestException
     * @throws      UnauthorizedClientException
     */
    public function put($url, $payload, $queryString = null)
    {
        return $this->tryRequest('put', $url, $payload, $queryString);
    }

    /**
     * @param       string          $url            The relative URL after the host name
     * @param       array|null      $queryString    Data to add as a queryString to the url
     * @return      mixed
     * @throws      ConnectException
     * @throws      RequestException
     * @throws      UnauthorizedClientException
     */
    public function delete($url, $queryString = null)
    {
        return $this->tryRequest('delete', $url, null, $queryString);
    }

    /**
     * @param       string          $method         The Http verb
     * @param       string          $url            The relative URL after the host name
     * @param       array|null      $payload        Contents of the body
     * @param       array|null      $queryString    Data to add as a queryString to the url
     * @param       bool            $firstTry
     * @return      mixed
     * @throws      ConnectException
     * @throws      RequestException
     * @throws      UnauthorizedClientException
     */
    protected function tryRequest($method, $url, $payload = null, $queryString = null, $firstTry = true)
    {
        try
        {
            if (empty($this->apiConfiguration->getAccessToken()))
                $this->refreshAccessToken();
            return $this->httpRequest->makeHttpRequest($method, $url, $payload, $queryString);
        }
        catch (ConnectException $c)
        {
            throw $c;
        }
        catch (RequestException $e)
        {
            if ($e->getResponse()->getStatusCode() == 401)
            {
                if ($firstTry)
                {
                    $this->refreshAccessToken();
                    return $this->tryRequest($method, $url, $payload, $queryString, false);
                }
            } else {
                throw $e;
            }
        }
    }

    
    /**
     * Get the Account associated with the provided access_token.
     * Does not validate ApiConfiguration and does not refresh access_token if it's bad
     * @param   string      $access_token
     * @return  array
     * @throws  Exceptions\RequiredFieldMissingException
     */
    public function getAccountForAccessToken($access_token)
    {
        return $this->httpRequest->getAccessTokenForAccount($access_token);
    }

    /**
     * @return Responses\CreateAccessTokenResponse
     * @throws Exceptions\RequiredFieldMissingException
     * @throws Exceptions\UnauthorizedClientException
     */
    public function refreshAccessToken()
    {
        $accessTokenResponse    = $this->httpRequest->requestAccessToken();
        $this->apiConfiguration->setAccessToken($accessTokenResponse->getAccessToken());

        return $accessTokenResponse;
    }
    
    /**
     * @return ApiConfiguration
     */
    public function getApiConfiguration()
    {
        return $this->apiConfiguration;
    }

    /**
     * @param   ApiConfigurationContract|array|string|null $apiConfiguration
     * @throws  \Exception
     */
    public function setApiConfiguration($apiConfiguration = null)
    {
        if (is_string($apiConfiguration) || is_null($apiConfiguration))
        {
            if (!is_null($apiConfiguration))
            {
                if (!is_dir($apiConfiguration))
                    throw new \Exception('The provided directory location does not exist at ' . $apiConfiguration);

                $dotEnv                         = new Dotenv($apiConfiguration);
                $dotEnv->load();
            }
            $data         = [
                'username'              => getenv('TURBOSHIP_USERNAME')             ?: null,
                'password'              => getenv('TURBOSHIP_PASSWORD')             ?: null,
                'clientId'              => getenv('TURBOSHIP_CLIENT_ID')            ?: null,
                'clientSecret'          => getenv('TURBOSHIP_CLIENT_SECRET')        ?: null,
                'scope'                 => getenv('TURBOSHIP_SCOPE')                ?: null,
                'grantType'             => getenv('TURBOSHIP_GRANT_TYPE')           ?: null,
                'accessToken'           => getenv('TURBOSHIP_ACCESS_TOKEN')         ?: null,
                'authEndpoint'          => getenv('TURBOSHIP_AUTH_ENDPOINT')        ?: null,
                'locationsEndPoint'     => getenv('TURBOSHIP_LOCATIONS_ENDPOINT')   ?: null,
                'postageEndPoint'       => getenv('TURBOSHIP_POSTAGE_ENDPOINT')     ?: null,
            ];
            $this->apiConfiguration     = new ApiConfiguration($data);

        } else {
            if (is_array($apiConfiguration)) {
                $data = [
                    'username'          => AU::get($apiConfiguration['username']),
                    'password'          => AU::get($apiConfiguration['password']),
                    'clientId'          => AU::get($apiConfiguration['clientId']),
                    'clientSecret'      => AU::get($apiConfiguration['clientSecret']),
                    'scope'             => AU::get($apiConfiguration['scope']),
                    'grantType'         => AU::get($apiConfiguration['grantType']),
                    'accessToken'       => AU::get($apiConfiguration['accessToken']),
                    'authEndpoint'      => AU::get($apiConfiguration['authEndpoint']),
                    'locationsEndPoint' => AU::get($apiConfiguration['locationsEndPoint']),
                    'postageEndPoint'   => AU::get($apiConfiguration['postageEndPoint']),
                ];
                $this->apiConfiguration = new ApiConfiguration($data);

            } else {
                if ($apiConfiguration instanceof ApiConfigurationContract)
                    $this->apiConfiguration = $apiConfiguration;
            }
        }
    }
}