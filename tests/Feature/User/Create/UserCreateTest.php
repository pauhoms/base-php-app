<?php

namespace Tests\Feature\User\Create;

use Tests\Feature\FeatureTestCase;

final class UserCreateTest extends FeatureTestCase
{
    /** @test */
    public function userShouldBeCreated(): void
    {
        $payload = [
            "user-name" => "test",
            "password" => "test"
        ];

        $result = $this->createRequest("POST", "/api/user/create", $payload);

        $this->assertEquals(200, $result->getStatusCode());
    }

    /** @test */
    public function userShouldBeExist(): void
    {
        $payload = [
            "user-name" => "name",
            "password" => "test"
        ];

        $result = $this->createRequest("POST", "/api/user/create", $payload);

        $this->assertEquals(409, $result->getStatusCode());
    }


    /** @test */
    public function payloadShouldBeInvalid(): void
    {
        $result = $this->createRequest("POST", "/api/user/create");
        $this->assertEquals(415, $result->getStatusCode());

        $result = $this->createRequest("POST", "/api/user/create", []);
        $this->assertEquals(415, $result->getStatusCode());

        $result = $this->createRequest("POST", "/api/user/create", ["user-name" => "test1"]);
        $this->assertEquals(415, $result->getStatusCode());

        $result = $this->createRequest("POST", "/api/user/create", ["password" => "test1"]);
        $this->assertEquals(415, $result->getStatusCode());
    }
}
