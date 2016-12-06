<?php

namespace PhongoDB;

/**
 * Class ArrayList
 * @package PhongoDB
 *
 * @property integer $length
 */
class ArrayList implements \ArrayAccess
{

    private $container = [];
    private $arrayListType;

    public function __construct($arrayListType = null)
    {
        $this->arrayListType = is_object($arrayListType) ? get_class($arrayListType) : $arrayListType;
    }

    public function __get($name)
    {
        if ($name === 'length')
            return $this->length();

        return $this->{$name};
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function add()
    {
        $item = func_get_args();

        if (count($item) > 1) {
            foreach ($item as $value)
                $this->add($value);

            return true;
        }

        if (!$this->validateItemType($item[0]))
            return false;

        $this->container[] = $item[0];

        return true;
    }

    public function set($index, $item)
    {
        if (!$this->validateItemType($item))
            return false;

        $this->container[$index] = $item;

        return true;
    }

    public function getItem($index)
    {
        if (isset($this->container[$index]))
            return $this->container[$index];

        return null;
    }

    public function all()
    {
        return $this->container;
    }

    public function length()
    {
        return count($this->container);
    }

    public function remove($index)
    {
        unset($this->container[$index]);
    }

    private function validateItemType($item)
    {
        if (is_null($this->arrayListType))
            return true;

        if (is_object($item))
            $item = get_class($item);
        else
            $item = gettype($item);

        if ($item === $this->arrayListType)
            return true;

        return false;
    }

}
