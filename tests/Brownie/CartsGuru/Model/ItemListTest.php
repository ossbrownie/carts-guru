<?php

use Brownie\CartsGuru\Model\ItemList;
use Prophecy\Prophecy\MethodProphecy;

class ItemListTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var ItemList
     */
    protected $itemListClass;

    protected function setUp()
    {
        $this->itemListClass = new ItemList();
    }

    protected function tearDown()
    {
        $this->itemListClass = null;
    }

    public function testAddItem()
    {
        $itemMock = $this
            ->prophesize('Brownie\CartsGuru\Model\Item');

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

        $this->assertCount(0, $this->itemListClass->toArray());
        $this->itemListClass->add($item);
        $this->assertCount(1, $this->itemListClass->toArray());
        $this->assertEquals(array($item), $this->itemListClass->toArray());
        $this->assertEquals('items', $this->itemListClass->getKeyName());
        $this->assertEquals(1, $this->itemListClass->count());
    }
}
