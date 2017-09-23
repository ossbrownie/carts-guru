<?php

use Brownie\CartsGuru\HTTPClient\Query;

class QueryTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var Query
     */
    private $httpClientQueryClass;

    protected function setUp()
    {
        $this->httpClientQueryClass = new Query();
    }

    protected function tearDown()
    {
        $this->httpClientQueryClass = null;
    }

    public function testSetGetToArray()
    {
        $apiUrl = 'http://localhost';
        $xAuthKey = 'xxxx-xxxx-xxxx-xxxx';
        $data = '{DATA}';
        $method = 'POST';
        $timeOut = 150;

        $this
            ->httpClientQueryClass
            ->setApiUrl($apiUrl)
            ->setXAuthKey($xAuthKey)
            ->setData($data)
            ->setMethod($method)
            ->setTimeOut($timeOut);

        $this->assertEquals($apiUrl, $this->httpClientQueryClass->getApiUrl());
        $this->assertEquals($xAuthKey, $this->httpClientQueryClass->getXAuthKey());
        $this->assertEquals($data, $this->httpClientQueryClass->getData());
        $this->assertEquals($method, $this->httpClientQueryClass->getMethod());
        $this->assertEquals($timeOut, $this->httpClientQueryClass->getTimeOut());
        $this->assertEquals(array(
            'apiUrl' => $apiUrl,
            'xAuthKey' => $xAuthKey,
            'data' => $data,
            'method' => $method,
            'timeOut' => $timeOut
        ), $this->httpClientQueryClass->toArray());
    }
}
