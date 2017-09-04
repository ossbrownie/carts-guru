<?php

use Brownie\CartsGuru\Model\Order;
use Prophecy\Prophecy\MethodProphecy;

class OrderTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var Order
     */
    protected $orderClass;

    protected function setUp()
    {
        $this->orderClass = new Order();
    }

    protected function tearDown()
    {
        $this->orderClass = null;
    }

    public function testSetGetRequiredParamas()
    {
        $itemMock = $this
            ->prophesize('Brownie\CartsGuru\Model\Item');

        $methodValidate = new MethodProphecy(
            $itemMock,
            'validate',
            array()
        );
        $itemMock
            ->addMethodProphecy(
                $methodValidate->willReturn(null)
            );

        $methodToArray = new MethodProphecy(
            $itemMock,
            'toArray',
            array()
        );
        $itemMock
            ->addMethodProphecy(
                $methodToArray->willReturn(array())
            );

        $item = $itemMock->reveal();

        /*
        $methodGetItems = new MethodProphecy(
            $this->orderClass,
            'getItems',
            array()
        );
        $this
            ->orderClass
            ->addMethodProphecy(
                $methodGetItems->willReturn(array(
                    $item
                ))
            );
        */

        $id = 'test-order-0007';
        $siteId = 'xxx';
        $totalATI = 200;
        $totalET = 150;
        $state = 'cancel';
        $accountId = 201720;
        $firstname = 'Tester';
        $email = 'tester@site.com';
        $country = 'United States';
        $countryCode = 'USA';

        $this
            ->orderClass
            ->setId($id)
            ->setSiteId($siteId)
            ->setTotalATI($totalATI)
            ->setTotalET($totalET)
            ->setState($state)
            ->setAccountId($accountId)
            ->setFirstname($firstname)
            ->setEmail($email)
            ->setCountry($country)
            ->setCountryCode($countryCode);

        $this
            ->orderClass
            ->addItem($item);

        $this
            ->orderClass
            ->validate();

        $this->assertEquals($id, $this->orderClass->getId());
        $this->assertEquals($siteId, $this->orderClass->getSiteId());
        $this->assertEquals($totalATI, $this->orderClass->getTotalATI());
        $this->assertEquals($totalET, $this->orderClass->getTotalET());
        $this->assertEquals($state, $this->orderClass->getState());
        $this->assertEquals($accountId, $this->orderClass->getAccountId());
        $this->assertEquals($firstname, $this->orderClass->getFirstname());
        $this->assertEquals($email, $this->orderClass->getEmail());
        $this->assertEquals($country, $this->orderClass->getCountry());
        $this->assertEquals($countryCode, $this->orderClass->getCountryCode());
    }

    /**
     * @expectedException       Brownie\CartsGuru\Exception\ValidateException
     */
    public function testValidateException()
    {
        $this
            ->orderClass
            ->validate();
    }
}
