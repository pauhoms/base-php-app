<?php


namespace Tests\Authentication;


class HealthCheckTest extends AuthenticationFeatureTestCase
{
    /** @test */
    public function databaseShouldBeConnected(): void
    {
        $request = $this->createRequest('GET', '/api/authentication/health-check');
        $isConnected = $this->getResponseResult($request)['mariadb'];

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertTrue($isConnected);
    }
}