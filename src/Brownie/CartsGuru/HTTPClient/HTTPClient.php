<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\HTTPClient;

use Brownie\CartsGuru\Exception\InvalidCodeException;
use Brownie\CartsGuru\Exception\JsonException;
use Brownie\CartsGuru\Config;
use Brownie\CartsGuru\Model\Base\DataModel;

/**
 * HTTP client.
 */
class HTTPClient
{
    const HTTP_METHOD_GET = 'GET';

    const HTTP_METHOD_POST = 'POST';

    const HTTP_METHOD_PUT = 'PUT';

    const HTTP_METHOD_DELETE = 'DELETE';

    const HTTP_CODE_200 = 200;

    /**
     * CartsGuru configuration.
     * @var Config
     */
    private $config;

    /**
     * HTTP client.
     * @var Client
     */
    private $client;

    /**
     * Sets incoming data.
     *
     * @param Client    $client     HTTP client.
     * @param Config    $config     CartsGuru configuration.
     */
    public function __construct(Client $client, Config $config)
    {
        $this
            ->setClient($client)
            ->setConfig($config);
    }

    /**
     * Sets the request client.
     * Returns the current object.
     *
     * @param Client $client
     *
     * @return self
     */
    private function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Sets the CartsGuru configuration.
     * Returns the current object.
     *
     * @param Config    $config     CartsGuru configuration.
     *
     * @return self
     */
    private function setConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Returns request client.
     *
     * @return Client
     */
    private function getClient()
    {
        return $this->client;
    }

    /**
     * Returns CartsGuru configuration.
     *
     * @return Config
     */
    private function getConfig()
    {
        return $this->config;
    }

    /**
     * Performs a network request in CartsGuru.
     * Returns the response from CartsGuru.
     *
     * @param int               $checkHTTPCode          Checked HTTP Code
     * @param string            $endpoint               The access endpoint to the resource.
     * @param array|DataModel   $data                   An array of data to send.
     * @param string            $method                 Query Method.
     * @param boolean           $ignoreEmptyResponse    Semaphore of ignoring an empty response.
     *
     * @throws InvalidCodeException
     * @throws JsonException
     *
     * @return array
     */
    public function request(
        $checkHTTPCode,
        $endpoint,
        $data = array(),
        $method = self::HTTP_METHOD_GET,
        $ignoreEmptyResponse = false
    ) {
        $apiUrl = $this->getApiUrl($endpoint);

        if (is_object($data)) {
            $data = $data->toArray();
        }

        $query = new Query();
        $query
            ->setApiUrl($apiUrl)
            ->setXAuthKey($this->getConfig()->getApiAuthKey())
            ->setData($data)
            ->setMethod($method)
            ->setTimeOut($this->getConfig()->getTimeOut());

        $response = $this
            ->getClient()
            ->httpRequest($query);

        $responseBody = $this->parseResponse($ignoreEmptyResponse, $response->getBody());

        $this->checkingHTTPCode(
            $checkHTTPCode,
            $response->getHttpCode(),
            is_array($responseBody) && isset($responseBody['error']) ? ', ' . $responseBody['error'] : ''
        );

        return array(
            'response' => $responseBody,
            'runtime' => $response->getRuntime(),
        );
    }

    /**
     * Returns the text of the JSON parsing error.
     *
     * @param integer   $errorId        Error ID
     *
     * @return string
     */
    public function getJsonLastErrorMsg($errorId)
    {
        $message = 'Unknown error';

        $errors = array(
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'Underflow or the modes mismatch',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
        );

        if (!empty($errors[$errorId])) {
            $message = $errors[$errorId];
        }

        return $message;
    }

    /**
     * Creates a complete URL to the resource.
     * Returns the created URL.
     *
     * @param string    $endpoint   API Endpoint.
     *
     * @return string
     */
    private function getApiUrl($endpoint)
    {
        return implode(
            '/',
            array(
                $this->getConfig()->getApiUrl(),
                $endpoint
            )
        );
    }

    /**
     * Checking HTTP Code.
     *
     * @param int       $checkHTTPCode      Verification HTTP code.
     * @param int       $httpCode           Verifiable HTTP code.
     * @param string    $message            Error message.
     *
     * @throws InvalidCodeException
     */
    private function checkingHTTPCode($checkHTTPCode, $httpCode, $message)
    {
        if ($checkHTTPCode != $httpCode) {
            throw new InvalidCodeException($httpCode . ($message));
        }
    }

    /**
     * Parsing with the API response.
     *
     * @param bool      $ignoreEmptyResponse    A sign of ignoring an empty response.
     * @param string    $responseBody           HTTP response from the API.
     *
     * @return array
     *
     * @throws JsonException
     */
    private function parseResponse($ignoreEmptyResponse, $responseBody)
    {
        $response = array();
        if (!$ignoreEmptyResponse && !empty($responseBody)) {
            $response = json_decode($responseBody, true);

            /**
             * Parse Json checking.
             */
            if (json_last_error() != JSON_ERROR_NONE) {
                throw new JsonException($this->getJsonLastErrorMsg(json_last_error()));
            }
        }
        return $response;
    }
}
