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
use Brownie\CartsGuru\Model\DataModel;

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
     * Returns the status of the request.
     *
     * @param Cart      $cart    Description of the cart.
     *
     * @return boolean
     */
    public function trackCart(Cart $cart)
    {
        return $this->track($cart);
    }

    /**
     * Track Order.
     * Returns the status of the request.
     *
     * @param Order     $order      Description of the order.
     *
     * @return boolean
     */
    public function trackOrder(Order $order)
    {
        return $this->track($order);
    }

    /**
     * Request track.
     * Returns the status of the request.
     *
     * @param DataModel     $model      Description of the data.
     *
     * @return bool
     */
    private function track(DataModel $model)
    {
        $model->setSiteId($this->getSiteId());
        $model->validate();

        $response = $this
            ->getHttpClient()
            ->request(
                HTTPClient::HTTP_CODE_200,
                $model->getEndpoint(),
                $model,
                HTTPClient::HTTP_METHOD_POST
            );

        return isset($response['response']['status']) && ('success' == $response['response']['status']);
    }
}
