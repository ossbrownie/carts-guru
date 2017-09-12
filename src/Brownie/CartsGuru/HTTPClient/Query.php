<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\HTTPClient;

use Brownie\CartsGuru\Model\Base\ArrayList;

/**
 * HTTP client query params.
 *
 * @method Query    setApiUrl($apiUrl)           Sets API URL.
 * @method Query    setXAuthKey($xAuthKey)       Sets API auth key.
 * @method Query    setData($data)               Sets arguments of the query.
 * @method Query    setMethod($method)           Sets request method.
 * @method Query    setTimeOut($timeOut)         Sets query Timeout.
 * @method string   getApiUrl()                  Returns API URL.
 * @method string   getXAuthKey()                Returns API auth key.
 * @method array    getData()                    Returns arguments of the query.
 * @method string   getMethod()                  Returns request method.
 * @method int      getTimeOut()                 Returns query Timeout.
 */
class Query extends ArrayList
{

    protected $fields = array(
        'apiUrl' => '',
        'xAuthKey' => '',
        'data' => array(),
        'method' => HTTPClient::HTTP_METHOD_GET,
        'timeOut' => 60,
    );
}
