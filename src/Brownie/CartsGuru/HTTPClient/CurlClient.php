<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\HTTPClient;

use Brownie\CartsGuru\Exception\ClientException;

/**
 * HTTP client based on cURL.
 */
class CurlClient implements Client
{

    /**
     * Performs a network request in CartsGuru.
     * Returns the response from CartsGuru.
     *
     * @param Query       $query        HTTP client query params.
     *
     * @throws ClientException
     *
     * @return array
     */
    public function httpRequest(Query $query)
    {
        $curl = $this->getCurlClient($query);

        /**
         * Executes a network resource request.
         */
        $responseBody = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        /**
         * Network error checking.
         */
        if ((0 != curl_errno($curl)) || !is_string($responseBody)) {
            throw new ClientException(curl_error($curl));
        }

        $runtime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);

        curl_close($curl);

        return array(
            $responseBody,
            $httpCode,
            $runtime
        );
    }

    /**
     * Curl init.
     *
     * @param Query       $query        HTTP client query params.
     *
     * @return resource
     */
    private function getCurlClient(Query $query)
    {
        $curl = curl_init($query->getApiUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($query->getData()));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $query->getMethod());
        curl_setopt($curl, CURLOPT_TIMEOUT, $query->getTimeOut());
        curl_setopt($curl, CURLOPT_NOPROGRESS, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $query->getApiUrl());
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Connection: close',
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8',
            'x-auth-key: ' . $query->getXAuthKey()
        ));
        return $curl;
    }
}
