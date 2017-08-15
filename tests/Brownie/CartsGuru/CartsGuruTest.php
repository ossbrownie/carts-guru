<?php

use Brownie\CartsGuru\CartsGuru;
use Brownie\CartsGuru\HTTPClient\HTTPClient;
use Prophecy\Prophecy\MethodProphecy;
use Brownie\CartsGuru\HTTPClient\Client;
use Brownie\CartsGuru\Config;
use Brownie\CartsGuru\Model\Cart;
use Brownie\CartsGuru\Model\Order;

class CartGuruTest extends PHPUnit_Framework_TestCase
{

    /**
     * The test class.
     *
     * @var CartsGuru
     */
    protected $cartsGuruClass;

    /**
     * HTTPClient mock object.
     *
     * @var HTTPClient
     */
    protected $httpClient;

    protected function setUp()
    {
        $client = $this
            ->prophesize(Client::class)
            ->reveal();

        $config = $this
            ->prophesize(Config::class)
            ->reveal();

        $this->httpClient = $this
            ->prophesize(HTTPClient::class)
            ->willBeConstructedWith([
                $client,
                $config
            ]);

        $this->cartsGuruClass = new CartsGuru($this->httpClient->reveal(), 'xxxx-xxxx-xxxx');
    }

    protected function tearDown()
    {
        $this->cartsGuruClass = null;
    }

    public function testTrackCart()
    {
        $cartMock = $this
            ->prophesize(Cart::class);

        $cartMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $cartMock,
                    'validate',
                    []
                ))->willReturn(null)
            );

        $cartMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $cartMock,
                    'toArray',
                    []
                ))->willReturn([])
            );

        $cartMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $cartMock,
                    'setSiteId',
                    ['xxxx-xxxx-xxxx']
                ))->willReturn(null)
            );

        $cart = $cartMock->reveal();

        $this
            ->httpClient
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->httpClient,
                    'request',
                    [200, 'carts', $cart, 'POST']
                ))->willReturn([
                    'response' => [
                        'status' => 'success',
                    ],
                    'runtime' => '0.7'
                ])
            );

        $status = $this->cartsGuruClass->trackCart($cart);

        $this->assertTrue($status);
    }

    public function testTrackOrder()
    {
        $orderMock = $this
            ->prophesize(Order::class);

        $orderMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $orderMock,
                    'validate',
                    []
                ))->willReturn(null)
            );

        $orderMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $orderMock,
                    'toArray',
                    []
                ))->willReturn([])
            );

        $orderMock
            ->addMethodProphecy(
                (new MethodProphecy(
                    $orderMock,
                    'setSiteId',
                    ['xxxx-xxxx-xxxx']
                ))->willReturn(null)
            );

        $order = $orderMock->reveal();

        $this
            ->httpClient
            ->addMethodProphecy(
                (new MethodProphecy(
                    $this->httpClient,
                    'request',
                    [200, 'orders', $order, 'POST']
                ))->willReturn([
                    'response' => [
                        'status' => 'success',
                    ],
                    'runtime' => '0.7'
                ])
            );

        $status = $this->cartsGuruClass->trackOrder($order);

        $this->assertTrue($status);
    }
}
