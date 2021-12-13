<?php

namespace Tests\Feature\User\Get;

use Tests\Feature\FeatureTestCase;

final class UserAuthenticatorTest extends FeatureTestCase
{
    /** @test */
    public function userShouldBeAuthenticated(): void
    {
        $payload = [
            "user-name" => "name",
            "password" => "test"
        ];

        $result = $this->createRequest("GET", "/api/user/authenticate", null, $payload);

        $this->assertEquals(200, $result->getStatusCode());
    }

    /** @test */
    public function passwordShouldBeInvalid(): void
    {
        $payload = [
            "user-name" => "name",
            "password" => "test2"
        ];

        $result = $this->createRequest("GET", "/api/user/authenticate", null, $payload);

        $this->assertEquals(401, $result->getStatusCode());
    }


    /** @test */
    public function payloadShouldBeInvalid(): void
    {
        $result = $this->createRequest("GET", "/api/user/authenticate");
        $this->assertEquals(415, $result->getStatusCode());

        $result = $this->createRequest("POST", "/api/user/create", []);
        $this->assertEquals(415, $result->getStatusCode());


        $result = $this->createRequest("GET","/api/user/authenticate", ["user-name" => "test1"]);
        $this->assertEquals(415, $result->getStatusCode());

        $result = $this->createRequest("GET", "/api/user/authenticate", ["password" => "test1"]);
        $this->assertEquals(415, $result->getStatusCode());
    }
}
