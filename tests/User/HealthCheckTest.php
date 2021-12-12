<?php


namespace Tests\User;


class HealthCheckTest extends AuthenticationFeatureTestCase
{
    /** @test */
    public function databaseShouldBeConnected(): void
    {
        $request = $this->createRequest('GET', '/api/health-check');
        $isConnected = $this->getResponseResult($request)['mariadb'];

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertTrue($isConnected);
    }
}