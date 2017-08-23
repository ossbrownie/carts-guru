<?php

use Brownie\CartsGuru\HTTPClient\HTTPClient;
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
            ->prophesize('Brownie\CartsGuru\HTTPClient\Client');

        $config = $this
            ->prophesize('Brownie\CartsGuru\Config');

        $methodGetApiUrl = new MethodProphecy(
            $config,
            'getApiUrl',
            array()
        );
        $config->addMethodProphecy(
            $methodGetApiUrl->willReturn('https://localhost/api')
        );

        $methodGetTimeout = new MethodProphecy(
            $config,
            'getTimeOut',
            array()
        );
        $config->addMethodProphecy(
            $methodGetTimeout->willReturn(100)
        );

        $methodGetApiAuthKey = new MethodProphecy(
            $config,
            'getApiAuthKey',
            array()
        );
        $config->addMethodProphecy(
            $methodGetApiAuthKey->willReturn('xxxx-xxxx-xxxx')
        );

        $this->httpClientClass = new HTTPClient($this->clientMock->reveal(), $config->reveal());
    }

    protected function tearDown()
    {
        $this->httpClientClass = null;
    }

    public function testRequestTrackCart()
    {
        $methodHttprequest = new MethodProphecy(
            $this->clientMock,
            'httpRequest',
            array('https://localhost/api/carts', 'xxxx-xxxx-xxxx', array(), 'POST', 100)
        );
        $this
            ->clientMock
            ->addMethodProphecy(
                $methodHttprequest->willReturn(array(
                    '{"status":"success"}',
                    200,
                    0.7
                ))
            );

        $status = $this->httpClientClass->request(200, 'carts', array(), 'POST');

        $this->assertEquals('success', $status['response']['status']);
    }

    public function testRequestTrackOrder()
    {
        $methodHttpRequest = new MethodProphecy(
            $this->clientMock,
            'httpRequest',
            array('https://localhost/api/orders', 'xxxx-xxxx-xxxx', array(), 'POST', 100)
        );
        $this
            ->clientMock
            ->addMethodProphecy(
                $methodHttpRequest->willReturn(array(
                    '{"status":"success"}',
                    200,
                    0.7
                ))
            );

        $status = $this->httpClientClass->request(200, 'orders', array(), 'POST');

        $this->assertEquals('success', $status['response']['status']);
    }
}
