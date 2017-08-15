<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru;

use Brownie\CartsGuru\HTTPClient\HTTPClient;
use Brownie\CartsGuru\Model\Cart;
use Brownie\CartsGuru\Model\Order;

/**
 * CartsGuru API.
 */
class CartsGuru
{

    /**
     * @var HTTPClient
     */
    private $httpClient;

    /**
     * Site ID.
     *
     * @var string
     */
    private $siteId;

    /**
     * Sets incoming data.
     *
     * @param HTTPClient    $httpClient     HTTP client.
     * @param string        $siteId         Site ID.
     */
    public function __construct(HTTPClient $httpClient, $siteId)
    {
        $this
            ->setHttpClient($httpClient)
            ->setSiteId($siteId);
    }

    /**
     * Sets an HTTP client.
     * Returns the current object.
     *
     * @param HTTPClient $httpClient Http client
     *
     * @return self
     */
    private function setHttpClient(HTTPClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * Returns HTTP client.
     *
     * @return HTTPClient
     */
    private function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Set site ID.
     *
     * @param string    $siteId     Site ID
     *
     * @return self
     */
    private function setSiteId($siteId)
    {
        $this->siteId = $siteId;
        return $this;
    }

    /**
     * Return site ID.
     *
     * @return string
     */
    private function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * Track Cart.
     *
     * @param Cart $cart
     *
     * @return boolean
     */
    public function trackCart(Cart $cart)
    {
        $cart->setSiteId($this->getSiteId());
        $cart->validate();

        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'carts',
                $cart,
                HTTPClient::HTTP_METHOD_POST
            );

        return isset($response['response']['status']) && ('success' == $response['response']['status']);
    }

    /**
     * Track Order.
     *
     * @param Order $order
     *
     * @return boolean
     */
    public function trackOrder(Order $order)
    {
        $order->setSiteId($this->getSiteId());
        $order->validate();

        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                'orders',
                $order,
                HTTPClient::HTTP_METHOD_POST
            );

        return isset($response['response']['status']) && ('success' == $response['response']['status']);
    }
}
