<?php

namespace TurboShip\Api\Contracts;

interface ApiConfigurationContract
{
    
    public function getUsername();
    public function getPassword();
    public function getClientId();
    public function getClientSecret();
    public function getScope();
    public function getGrantType();
    public function getAccessToken();
    public function getAuthEndpoint();
    public function getLocationsEndPoint();
    public function getPostageEndPoint();
    public function getDefaultEndPoint();
    
}