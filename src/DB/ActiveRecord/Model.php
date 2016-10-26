<?php

namespace PhongoDB\DB\ActiveRecord;


abstract class Model
{

    protected $_methods = [];
    protected $_attributes = [];

    public function __construct()
    {
        $oModelRef = new \ReflectionClass(get_class($this));
        foreach ($oModelRef->getMethods() as $method) {
            $this->_methods[] = $method->getName();
        }

        foreach ($oModelRef->getProperties() as $property) {
            if ($property->class === get_class($this))
                $this->_attributes[] = $property->getName();
        }
    }

    public function getAttributes()
    {
        $attributes = [];
        foreach ($this->_attributes as $attr) {
            $attributes[$attr] = $this->{$attr};
        }

        return $attributes;
    }

    public function setAttributes($attributes)
    {
        foreach ($attributes as $attr => $value) {
            if (in_array($attr, $this->_attributes)) {
                $this->{$attr} = $value;
            }
        }
    }

}