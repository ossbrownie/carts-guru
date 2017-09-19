<?php

use Brownie\CartsGuru\CartsGuru;
use Brownie\CartsGuru\HTTPClient\HTTPClient;
use Prophecy\Prophecy\MethodProphecy;

class CartsGuruTest extends PHPUnit_Framework_TestCase
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
            ->prophesize('Brownie\CartsGuru\HTTPClient\Client')
            ->reveal();

        $config = $this
            ->prophesize('Brownie\CartsGuru\Config')
            ->reveal();

        $this->httpClient = $this
            ->prophesize('Brownie\CartsGuru\HTTPClient\HTTPClient')
            ->willBeConstructedWith(array(
                $client,
                $config
            ));

        $this->cartsGuruClass = new CartsGuru($this->httpClient->reveal(), 'xxxx-xxxx-xxxx');
    }

    protected function tearDown()
    {
        $this->cartsGuruClass = null;
    }

    public function testTrackCart()
    {
        $cartMock = $this
            ->prophesize('Brownie\CartsGuru\Model\Cart');

        $methodValidate = new MethodProphecy(
            $cartMock,
            'validate',
            array()
        );
        $cartMock
            ->addMethodProphecy(
                $methodValidate->willReturn(null)
            );

        $methodToArray = new MethodProphecy(
            $cartMock,
            'toArray',
            array()
        );
        $cartMock
            ->addMethodProphecy(
                $methodToArray->willReturn(array())
            );

        $methodSetSiteId = new MethodProphecy(
            $cartMock,
            'setSiteId',
            array('xxxx-xxxx-xxxx')
        );
        $cartMock
            ->addMethodProphecy(
                $methodSetSiteId->willReturn(null)
            );

        $methodGetEndpoint = new MethodProphecy(
            $cartMock,
            'getEndpoint',
            array()
        );
        $cartMock
            ->addMethodProphecy(
                $methodGetEndpoint->willReturn('carts')
            );

        $cart = $cartMock->reveal();

        $methodRequest = new MethodProphecy(
            $this->httpClient,
            'request',
            array(200, 'carts', $cart, 'POST')
        );
        $this
            ->httpClient
            ->addMethodProphecy(
                $methodRequest->willReturn(array(
                    'response' => array(
                        'status' => 'success',
                    ),
                    'runtime' => '0.7'
                ))
            );
        $status = $this->cartsGuruClass->trackCart($cart);

        $this->assertTrue($status);
    }

    public function testTrackOrder()
    {
        $orderMock = $this
            ->prophesize('Brownie\CartsGuru\Model\Order');

        $methodValidate = new MethodProphecy(
            $orderMock,
            'validate',
            array()
        );
        $orderMock
            ->addMethodProphecy(
                $methodValidate->willReturn(null)
            );

        $methodToArray = new MethodProphecy(
            $orderMock,
            'toArray',
            array()
        );
        $orderMock
            ->addMethodProphecy(
                $methodToArray->willReturn(array())
            );

        $methodSetSiteId = new MethodProphecy(
            $orderMock,
            'setSiteId',
            array('xxxx-xxxx-xxxx')
        );
        $orderMock
            ->addMethodProphecy(
                $methodSetSiteId->willReturn(null)
            );

        $methodGetEndpoint = new MethodProphecy(
            $orderMock,
            'getEndpoint',
            array()
        );
        $orderMock
            ->addMethodProphecy(
                $methodGetEndpoint->willReturn('orders')
            );

        $order = $orderMock->reveal();

        $methodRequest = new MethodProphecy(
            $this->httpClient,
            'request',
            array(200, 'orders', $order, 'POST')
        );
        $this
            ->httpClient
            ->addMethodProphecy(
                $methodRequest->willReturn(array(
                    'response' => array(
                        'status' => 'success',
                    ),
                    'runtime' => '0.7'
                ))
            );

        $status = $this->cartsGuruClass->trackOrder($order);

        $this->assertTrue($status);
    }
}
