<?php
/**
 * @category    Brownie/CartsGuru
 * @author      Brownie <oss.brownie@gmail.com>
 * @license     http://www.gnu.org/copyleft/lesser.html
 */

namespace Brownie\CartsGuru\Model\Base;

use Brownie\CartsGuru\Exception\UndefinedMethodException;

/**
 * Storage array.
 */
abstract class ArrayList
{

    public function __construct($values = array())
    {
        foreach ($values as $key => $value) {
            $method = 'set' . ucfirst($key);
            $this->$method($value);
        }
    }

    public function __call($name, $values)
    {
        $method = substr($name, 0, 3);
        $nameField = lcfirst(substr($name, 3));
        if (!array_key_exists($nameField, $this->fields)) {
            throw new UndefinedMethodException('Call to undefined method ' . $name);
        }
        return $this->$method($nameField, $values);
    }

    private function set($name, $values)
    {
        $this->fields[$name] = $values[0];
        return $this;
    }

    private function get($name)
    {
        return $this->fields[$name];
    }

    /**
     * Returns the field list as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->fields;
    }
}
