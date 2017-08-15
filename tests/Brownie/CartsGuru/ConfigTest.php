<?php

use Brownie\CartsGuru\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var Config
     */
    protected $configClass;

    protected function setUp()
    {
        $this->configClass = new Config();
    }

    protected function tearDown()
    {
        $this->configClass = null;
    }

    public function testSetGetTimeOut()
    {
        $timeOut = 100;
        $this->configClass->setTimeOut($timeOut);
        $this->assertEquals($timeOut, $this->configClass->getTimeOut());
    }

    public function testSetGetApiUrl()
    {
        $apiUrl = 'http://localhost/api';
        $this->configClass->setApiUrl($apiUrl);
        $this->assertEquals($apiUrl, $this->configClass->getApiUrl());
    }

    public function testSetGetApiAuthKey()
    {
        $apiAuthKey = 'xxxx-xxxx-xxxx';
        $this->configClass->setApiAuthKey($apiAuthKey);
        $this->assertEquals($apiAuthKey, $this->configClass->getApiAuthKey());
    }
}
