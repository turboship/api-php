<?php

namespace TurboShip\Api\tests;

use TurboShip\Api\ApiClient;

class AccessTokenTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param   bool $test
     * @return  ApiClient
     */
    public function testENVInstantiation($test = true)
    {
        $apiClient            = new ApiClient('./');
        
        if ($test)
            $this->assertInstanceOf('TurboShip\Api\ApiClient', $apiClient);
        
        return $apiClient;
    }

    /**
     * Test refreshing the access_token
     */
    public function testRefreshToken()
    {
        $apiClient            = $this->testENVInstantiation(false);
        $createAccessTokenResponse      = $apiClient->refreshAccessToken();
        $this->assertInstanceOf('TurboShip\Api\Responses\CreateAccessTokenResponse', $createAccessTokenResponse);
    }
    
    
}