<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\Model;

use Brownie\CartsGuru\Model\Base\ArrayList;
use Brownie\CartsGuru\Exception\ValidateException;

/**
 * Item Model.
 *
 * @method  Item    setId($id)
 * @method  Item    setLabel($label)
 * @method  Item    setQuantity($quantity)
 * @method  Item    setTotalATI($totalATI)
 * @method  Item    setTotalET($totalET)
 * @method  Item    setUrl($url)
 * @method  Item    setImageUrl($imageUrl)
 * @method  Item    setUniverse($universe)
 * @method  Item    setCategory($category)
 */
class Item extends ArrayList
{

    protected $fields = [
        'id' => null,               // SKU or product id
        'label' => null,            // Designation
        'quantity' => null,         // Count
        'totalATI' => null,         // Total price included taxes
        'totalET' => null,          // Total price excluded taxes
        'url' => null,              // URL of product sheet
        'imageUrl' => null,         // Image URL of the  product, size should be min 150*150, max 180*180
        'universe' => null,         // Main category of the product (optional)
        'category' => null,         // Sub category of the product (optional)
    ];

    /**
     * Validates contact data.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        $args = array_filter(parent::toArray());

        $keys = array_diff([
            'id',
            'label',
            'quantity',
            'totalATI',
            'totalET',
            'url',
            'imageUrl',
        ], array_keys($args));

        if ($keys) {
            throw new ValidateException('No required fields: ' . implode(', ', $keys));
        }
    }
}
