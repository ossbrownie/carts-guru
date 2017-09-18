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
        $cartMock = $this->prophesize('Brownie\CartsGuru\Model\Cart');
        $methodToArray = new MethodProphecy(
            $cartMock,
            'toArray',
            array()
        );
        $cartMock
            ->addMethodProphecy(
                $methodToArray->willReturn(array())
            );

        $cart = $cartMock->reveal();

        $methodHttprequest = new MethodProphecy(
            $this->clientMock,
            'httpRequest',
            array($this->getHTTPClientQuery('carts', 'POST', 100))
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

        $status = $this->httpClientClass->request(200, 'carts', array(), 'POST');//

        $this->assertEquals('success', $status['response']['status']);

        $status = $this->httpClientClass->request(200, 'carts', $cart, 'POST');

        $this->assertEquals('success', $status['response']['status']);
    }

    public function testRequestTrackOrder()
    {
        $orderMock = $this->prophesize('Brownie\CartsGuru\Model\Order');
        $methodToArray = new MethodProphecy(
            $orderMock,
            'toArray',
            array()
        );
        $orderMock
            ->addMethodProphecy(
                $methodToArray->willReturn(array())
        );

        $order = $orderMock->reveal();

        $methodHttpRequest = new MethodProphecy(
            $this->clientMock,
            'httpRequest',
            array($this->getHTTPClientQuery('orders', 'POST', 100))
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

        $status = $this->httpClientClass->request(200, 'orders', $order, 'POST');

        $this->assertEquals('success', $status['response']['status']);
    }

    /**
     * @expectedException     \Brownie\CartsGuru\Exception\JsonException
     */
    public function testJsonException()
    {
        $methodHttpRequest = new MethodProphecy(
            $this->clientMock,
            'httpRequest',
            array($this->getHTTPClientQuery('orders', 'POST', 100))
        );
        $this
            ->clientMock
            ->addMethodProphecy(
                $methodHttpRequest->willReturn(array(
                    'Json fail',
                    200,
                    0.7
                ))
            );

        $this->httpClientClass->request(200, 'orders', array(), 'POST');
    }

    /**
     * @expectedException     \Brownie\CartsGuru\Exception\InvalidCodeException
     */
    public function testInvalidCodeException()
    {
        $methodHttpRequest = new MethodProphecy(
            $this->clientMock,
            'httpRequest',
            array($this->getHTTPClientQuery('orders', 'POST', 100))
        );
        $this
            ->clientMock
            ->addMethodProphecy(
                $methodHttpRequest->willReturn(array(
                    '{}',
                    404,
                    0.7
                ))
            );

        $this->httpClientClass->request(200, 'orders', array(), 'POST');
    }

    public function testIgnoreEmptyResponse()
    {
        $methodHttpRequest = new MethodProphecy(
            $this->clientMock,
            'httpRequest',
            array($this->getHTTPClientQuery('orders', 'POST', 100))
        );
        $message = array();
        $this
            ->clientMock
            ->addMethodProphecy(
                $methodHttpRequest->willReturn(array(
                    $message,
                    200,
                    0.7
                ))
            );

        $response = $this->httpClientClass->request(200, 'orders', array(), 'POST', true);

        $this->assertEquals($message, $response['response']);
    }

    public function testGetJsonLastErrorMsg()
    {
        foreach (array(
            JSON_ERROR_DEPTH            => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH   => 'Underflow or the modes mismatch',
            JSON_ERROR_CTRL_CHAR        => 'Unexpected control character found',
            JSON_ERROR_SYNTAX           => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded',
            999                         => 'Unknown error',
                 ) as $key => $message) {

            $error = $this->httpClientClass->getJsonLastErrorMsg($key);
            $this->assertEquals($error, $message);
        }
    }

    private function getHTTPClientQuery($endpoint, $method, $timeOut)
    {
        $query = new \Brownie\CartsGuru\HTTPClient\Query();
        $query
            ->setApiUrl('https://localhost/api/' . $endpoint)
            ->setXAuthKey('xxxx-xxxx-xxxx')
            ->setData(array())
            ->setMethod($method)
            ->setTimeOut($timeOut);

        return $query;
    }
}
