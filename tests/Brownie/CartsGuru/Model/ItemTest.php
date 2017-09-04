<?php

use Brownie\CartsGuru\Model\Item;

class ItemTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var Item
     */
    protected $itemClass;

    protected function setUp()
    {
        $this->itemClass = new Item(array(
            'id' => 'test-product-007'
        ));
    }

    protected function tearDown()
    {
        $this->itemClass = null;
    }

    public function testSetGetRequiredParamas()
    {
        $id = 'test-product-007';
        $label = 'product';
        $quantity = 1;
        $totalATI = 200;
        $totalET= 150;
        $url = 'http://site.com/product/007';
        $imageUrl = 'http://site.com/product/007.jpg';

        $this
            ->itemClass
            ->setLabel($label)
            ->setQuantity($quantity)
            ->setTotalATI($totalATI)
            ->setTotalET($totalET)
            ->setUrl($url)
            ->setImageUrl($imageUrl);

        $this->itemClass->validate();

        $this->assertEquals($id, $this->itemClass->getId());
        $this->assertEquals($label, $this->itemClass->getLabel());
        $this->assertEquals($quantity, $this->itemClass->getQuantity());
        $this->assertEquals($totalATI, $this->itemClass->getTotalATI());
        $this->assertEquals($totalET, $this->itemClass->getTotalET());
        $this->assertEquals($url, $this->itemClass->getUrl());
        $this->assertEquals($imageUrl, $this->itemClass->getImageUrl());
    }

    /**
     * @expectedException       Brownie\CartsGuru\Exception\ValidateException
     */
    public function testValidateException()
    {
        $this->itemClass->validate();
    }

    /**
     * @expectedException       Brownie\CartsGuru\Exception\UndefinedMethodException
     */
    public function testUndefinedMethodException()
    {
        $this->itemClass->getUndefinedMethod();
    }
}
