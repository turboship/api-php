<?php

namespace TurboShip\Api\tests;

use TurboShip\Api\Api;

class AccessTokenTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param   bool $test
     * @return  Api
     */
    public function testENVInstantiation($test = true)
    {
        $apiClient            = new Api('./');
        
        if ($test)
            $this->assertInstanceOf('TurboShip\Api\Api', $apiClient);
        
        return $apiClient;
    }
    
    public function testRefreshToken()
    {
        $apiClient            = $this->testENVInstantiation(false);
        $createAccessTokenResponse      = $apiClient->refreshAccessToken();
        $this->assertInstanceOf('TurboShip\Api\Responses\CreateAccessTokenResponse', $createAccessTokenResponse);
    }
    
}