<?php

namespace Tests\Feature\User\Create;

use Tests\Feature\FeatureTestCase;

final class UserCreateTest extends FeatureTestCase
{
    /** @test */
    public function userShouldBeCreated(): void
    {
        $payload = [
            "name" => "test",
            "password" => "test"
        ];

        $result = $this->createRequest("POST", "/api/user/create", $payload);

        $this->assertEquals(200, $result->getStatusCode());
    }
}
