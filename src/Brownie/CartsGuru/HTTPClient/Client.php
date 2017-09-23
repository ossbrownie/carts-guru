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
     * @param Query       $query        HTTP client query params.
     *
     * @throws ClientException
     *
     * @return Response
     */
    public function httpRequest(Query $query);
}
