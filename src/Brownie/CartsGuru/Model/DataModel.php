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
 * Data model.
 */
abstract class DataModel extends ArrayList
{

    /**
     * Returns the field list as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $args = parent::toArray();
        if ($args['items']) {
            $list = array();
            foreach ($args['items']->toArray() as $item) {
                $list[] = array_filter($item->toArray());
            }
            $args['items'] = $list;
        }
        return array_filter($args);
    }

    /**
     * Add item.
     *
     * @param Item  $item   Product.
     *
     * @return self
     */
    public function addItem(Item $item)
    {
        if (is_null($this->getItemList())) {
            $this->setItemList(new ItemList());
        }
        $this->getItemList()->add($item);
        return $this;
    }

    /**
     * Set item list.
     *
     * @param ItemList      $itemList       Item list.
     *
     * @return self
     */
    private function setItemList(ItemList $itemList)
    {
        $this->fields['items'] = $itemList;
        return $this;
    }

    /**
     * Return item list.
     *
     * @return ItemList
     */
    private function getItemList()
    {
        return $this->fields['items'];
    }

    /**
     * Validates contact data.
     *
     * @throws ValidateException
     */
    public function validate()
    {
        $args = array_filter($this->toArray());

        $keys = array_diff($this->getRequiredFields(), array_keys($args));

        if (!empty($keys)) {
            throw new ValidateException('No required fields: ' . implode(', ', $keys));
        }

        foreach ($this->getItems()->toArray() as $item) {
            $item->validate();
        }
    }

    /**
     * Returns a list of required fields.
     *
     * @return array
     */
    protected function getRequiredFields()
    {
        return $this->requiredFields;
    }
}
