<?php

use Brownie\CartsGuru\Model\ItemList;
use Prophecy\Prophecy\MethodProphecy;
use Brownie\CartsGuru\Model\Item;

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
            ->prophesize(Item::class);

        $itemMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $itemMock,
                    'toArray',
                    []
                ))->willReturn([])
            );

        $item = $itemMock->reveal();

        $this->assertCount(0, $this->itemListClass->toArray());
        $this->itemListClass->add($item);
        $this->assertCount(1, $this->itemListClass->toArray());
        $this->assertEquals([$item], $this->itemListClass->toArray());
    }
}
