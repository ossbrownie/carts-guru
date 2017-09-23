<?php

use Brownie\CartsGuru\HTTPClient\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var Response
     */
    private $httpClientResponseClass;

    protected function setUp()
    {
        $this->httpClientResponseClass = new Response();
    }

    protected function tearDown()
    {
        $this->httpClientResponseClass = null;
    }

    public function testSetGetToArray()
    {
        $body = '{BODY}';
        $httpCode = 123;
        $runtime = 5.5;

        $this
            ->httpClientResponseClass
            ->setBody($body)
            ->setHttpCode($httpCode)
            ->setRuntime($runtime);

        $this->assertEquals($body, $this->httpClientResponseClass->getBody());
        $this->assertEquals($httpCode, $this->httpClientResponseClass->getHttpCode());
        $this->assertEquals($runtime, $this->httpClientResponseClass->getRuntime());
        $this->assertEquals(array(
            'body' => $body,
            'httpCode' => $httpCode,
            'runtime' => $runtime
        ), $this->httpClientResponseClass->toArray());
    }
}
