<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru;

use Brownie\CartsGuru\Model\Base\ArrayList;

/**
 * CartsGuru configuration.
 *
 * @method Config   setTimeOut($timeOut)    Sets connection timeout.
 * @method Config   setApiUrl($apiUrl)      Sets url API.
 * @method Config   setApiAuthKey($apiKey)  Sets api auth key.
 * @method int      getTimeOut()            Returns the connection timeout.
 * @method string   getApiUrl()             Returns the url API.
 * @method string   getApiAuthKey()         Returns the api auth key.
 */
class Config extends ArrayList
{

    protected $fields = array(
        'timeOut' => 30,
        'apiUrl' => 'https://api.carts.guru',
        'apiAuthKey' => 'x-auth-key'
    );
}
