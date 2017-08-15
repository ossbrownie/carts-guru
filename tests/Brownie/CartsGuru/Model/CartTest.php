<?php

use Brownie\CartsGuru\Model\Cart;
use Brownie\CartsGuru\Model\Item;
use Prophecy\Prophecy\MethodProphecy;

class CartTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var Cart
     */
    protected $cartClass;

    protected function setUp()
    {
        $this->cartClass = new Cart();
    }

    protected function tearDown()
    {
        $this->cartClass = null;
    }

    public function testSetGetRequiredParamas()
    {
        $itemMock = $this
            ->prophesize(Item::class);

        $itemMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $itemMock,
                    'validate',
                    []
                ))->willReturn(null)
            );

        $itemMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $itemMock,
                    'toArray',
                    []
                ))->willReturn([])
            );

        $item = $itemMock->reveal();

        $id = 'test-cart-0007';
        $siteId = 'xxx';
        $totalATI = 200;
        $totalET = 150;
        $accountId = 201720;
        $firstname = 'Tester';
        $email = 'tester@site.com';
        $country = 'United States';
        $countryCode = 'USA';

        $this
            ->cartClass
            ->setId($id)
            ->setSiteId($siteId)
            ->setTotalATI($totalATI)
            ->setTotalET($totalET)
            ->setAccountId($accountId)
            ->setFirstname($firstname)
            ->setEmail($email)
            ->setCountry($country)
            ->setCountryCode($countryCode);

        $this
            ->cartClass
            ->addItem($item);

        $this
            ->cartClass
            ->validate();

        $this->assertEquals($id, $this->cartClass->getId());
        $this->assertEquals($siteId, $this->cartClass->getSiteId());
        $this->assertEquals($totalATI, $this->cartClass->getTotalATI());
        $this->assertEquals($totalET, $this->cartClass->getTotalET());
        $this->assertEquals($accountId, $this->cartClass->getAccountId());
        $this->assertEquals($firstname, $this->cartClass->getFirstname());
        $this->assertEquals($email, $this->cartClass->getEmail());
        $this->assertEquals($country, $this->cartClass->getCountry());
        $this->assertEquals($countryCode, $this->cartClass->getCountryCode());
    }
}
