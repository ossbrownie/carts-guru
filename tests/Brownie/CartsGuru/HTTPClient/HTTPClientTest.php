<?php

use Brownie\CartsGuru\HTTPClient\HTTPClient;
use Brownie\CartsGuru\Config;
use Brownie\CartsGuru\HTTPClient\Client;
use Prophecy\Prophecy\MethodProphecy;

class HTTPClientTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var HTTPClient
     */
    private $httpClientClass;

    /**
     * Client mock object.
     *
     * @var Client
     */
    private $clientMock;

    protected function setUp()
    {
        $this->clientMock = $this
            ->prophesize(Client::class);

        $config = $this
            ->prophesize(Config::class);

        $config->addMethodProphecy(
            (new MethodProphecy(
                $config,
                'getApiUrl',
                []
            ))->willReturn('https://localhost/api')
        );

        $config->addMethodProphecy(
            (new MethodProphecy(
                $config,
                'getTimeOut',
                []
            ))->willReturn(100)
        );

        $config->addMethodProphecy(
            (new MethodProphecy(
                $config,
                'getApiAuthKey',
                []
            ))->willReturn('xxxx-xxxx-xxxx')
        );

        $this->httpClientClass = new HTTPClient($this->clientMock->reveal(), $config->reveal());
    }

    protected function tearDown()
    {
        $this->httpClientClass = null;
    }

    public function testRequestTrackCart()
    {
        $this
            ->clientMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->clientMock,
                    'httpRequest',
                    ['https://localhost/api/carts', 'xxxx-xxxx-xxxx', [], 'POST', 100]
                ))->willReturn([
                    '{"status":"success"}',
                    200,
                    0.7
                ])
            );

        $status = $this->httpClientClass->request(200, 'carts', [], 'POST');

        $this->assertEquals('success', $status['response']['status']);
    }

    public function testRequestTrackOrder()
    {
        $this
            ->clientMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->clientMock,
                    'httpRequest',
                    ['https://localhost/api/orders', 'xxxx-xxxx-xxxx', [], 'POST', 100]
                ))->willReturn([
                    '{"status":"success"}',
                    200,
                    0.7
                ])
            );

        $status = $this->httpClientClass->request(200, 'orders', [], 'POST');

        $this->assertEquals('success', $status['response']['status']);
    }
}
