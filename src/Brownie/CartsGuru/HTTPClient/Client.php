<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\HTTPClient;

use Brownie\CartsGuru\Exception\ClientException;

/**
 * HTTP client interface.
 */
interface Client
{

    /**
     * Performs a network request in CartsGuru.
     * Returns the response from CartsGuru.
     *
     * @param string    $apiUrl         API URL.
     * @param string    $xAuthKey       API auth key.
     * @param array     $data           Arguments of the query.
     * @param string    $method         Request method.
     * @param int       $timeOut        Query Timeout.
     *
     * @throws ClientException
     *
     * @return array
     */
    public function httpRequest(
        $apiUrl,
        $xAuthKey,
        $data,
        $method,
        $timeOut
    );
}
