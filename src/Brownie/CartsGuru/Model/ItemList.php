<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\Model;

use Brownie\CartsGuru\Model\Base\EntityList;

/**
 * Item list.
 */
class ItemList extends EntityList
{

    protected $keyName = 'items';

    /**
     * Add product.
     *
     * @param Item  $item   Product.
     *
     * @return self
     */
    public function add(Item $item)
    {
        parent::append($item);
        return $this;
    }
}
