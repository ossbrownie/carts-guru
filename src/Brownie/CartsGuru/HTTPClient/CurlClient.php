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
    ) {
        /**
         * Executes a network resource request.
         */
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeOut);
        curl_setopt($curl, CURLOPT_NOPROGRESS, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Connection: close',
            'Accept: application/json',
            'Content-Type: application/json; charset=utf-8',
            'x-auth-key: ' . $xAuthKey
        ));
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
}
