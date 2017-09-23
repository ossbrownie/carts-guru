<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\HTTPClient;

use Brownie\CartsGuru\Model\Base\ArrayList;

/**
 * HTTP client response.
 *
 * @method Response     setBody($body)              Sets body.
 * @method Response     setHttpCode($httpCode)      Sets HTTP code.
 * @method Response     setRuntime($runtime)
 * @method string       getBody()
 * @method int          getHttpCode()
 * @method float        getRuntime()
 */
class Response extends ArrayList
{

    protected $fields = array(
        'body' => '',
        'httpCode' => 0,
        'runtime' => -1,
    );
}
