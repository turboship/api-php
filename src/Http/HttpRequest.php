<?php

namespace TurboShip\Api\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use TurboShip\Api\Configuration\ApiConfiguration;
use TurboShip\Api\Exceptions\MissingCredentialException;
use TurboShip\Api\Exceptions\UnauthorizedClientException;
use TurboShip\Api\Requests\CreateAccessTokenRequest;
use TurboShip\Api\Responses\CreateAccessTokenResponse;

class HttpRequest
{

    /**
     * @var ApiConfiguration
     */
    protected $apiConfiguration;

    /**
     * @var Client
     */
    protected $guzzle;


    /**
     * HttpRequest constructor.
     * @param Client            $guzzle
     * @param ApiConfiguration  $apiConfiguration
     */
    public function __construct(Client $guzzle, ApiConfiguration $apiConfiguration)
    {
        $this->guzzle               = $guzzle;
        $this->apiConfiguration     = $apiConfiguration;
    }

    function makeHttpRequest($method, $url, $apiRequest = null, $queryString = null)
    {
        $urlEndPoint                = $this->apiConfiguration->getDefaultEndPoint() . '/' . $url;
        
        $data = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiConfiguration->getAccessToken()
            ],
            'json'    => $apiRequest,
            'query'   => $queryString
        ];


        try 
        {
            switch ($method) 
            {
                case 'post':
                    $response = $this->guzzle->post($urlEndPoint, $data);
                    break;
                case 'put':
                    $response = $this->guzzle->put($urlEndPoint, $data);
                    break;
                case 'delete':
                    $response = $this->guzzle->delete($urlEndPoint, $data);
                    break;
                case 'get':
                    $response = $this->guzzle->get($urlEndPoint, $data);
                    break;
                default:
                    throw new \Exception('Missing request method!');
            }

            if (in_array(current($response->getHeader('Content-Type')), ['image/png','image/jpg'])) 
            {
                $result = $response->getBody()->getContents();
            } else 
            {
                $result = json_decode($response->getBody(), true);
            }

            return $result;

        } catch (ConnectException $c) 
        {
            throw $c;
        } catch (RequestException $e) 
        {
            throw $e;
        }
    }
    
    public function getAccessTokenForAccount($access_token)
    {
        if (is_null($access_token))
            throw new MissingCredentialException('access_token');

        $urlEndPoint                = $this->apiConfiguration->getAuthEndpoint() . '/accounts/me';

        $data = [
            'headers' => ['Authorization' => 'Bearer ' . $access_token ]
        ];

        try 
        {
            $response               = $this->guzzle->get($urlEndPoint, $data);
            return json_decode($response->getBody(), true);
            
        } catch (ConnectException $c)
        {
            throw $c;
        } catch (RequestException $e)
        {
            throw $e;
        }
        
        
    }

    /**
     * @return CreateAccessTokenResponse
     * @throws MissingCredentialException
     * @throws UnauthorizedClientException
     */
    public function requestAccessToken()
    {

        try 
        {
            $this->validateCredentials();
        } catch (MissingCredentialException $e)
        {
            throw $e;
        }

        try 
        {
            $createAccessTokenRequest       = new CreateAccessTokenRequest();
            $createAccessTokenRequest->setClientId($this->apiConfiguration->getClientId());
            
            $createAccessTokenRequest->setClientSecret($this->apiConfiguration->getClientSecret());
            $createAccessTokenRequest->setGrantType($this->apiConfiguration->getGrantType());
            $createAccessTokenRequest->setUsername($this->apiConfiguration->getUsername());
            $createAccessTokenRequest->setPassword($this->apiConfiguration->getPassword());
            $createAccessTokenRequest->setScope($this->apiConfiguration->getScope());
            
            $endPoint                       = $this->apiConfiguration->getAuthEndpoint() . $createAccessTokenRequest->getEndPoint();
            $accessTokenResponse            = $this->guzzle->post(
                $endPoint,
                ['multipart' => $createAccessTokenRequest->getSerializedRequest()],
                ['http_errors' => false]
            );
        } catch (RequestException $e) 
        {
            throw new UnauthorizedClientException();
        }
        $accessTokenJson = json_decode($accessTokenResponse->getBody(), true);
        return new CreateAccessTokenResponse($accessTokenJson);
    }


    /**
     * @throws MissingCredentialException
     */
    private function validateCredentials()
    {
        if (empty($this->apiConfiguration->getUsername()))
            throw new MissingCredentialException('username');
        elseif (empty($this->apiConfiguration->getPassword()))
            throw new MissingCredentialException('password');
        elseif (empty($this->apiConfiguration->getClientId())) 
            throw new MissingCredentialException('clientId');
        elseif (empty($this->apiConfiguration->getClientSecret())) 
            throw new MissingCredentialException('clientSecret');
        elseif (empty($this->apiConfiguration->getScope()))
            throw new MissingCredentialException('scope');
    }
}