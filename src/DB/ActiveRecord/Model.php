<?php

namespace PhongoDB\DB\ActiveRecord;


abstract class Model
{

    protected $_methods = [];
    protected $_attributes = [];
    protected $_rules = [];

    private $_errors = [];

    public function __construct()
    {
        $oModelRef = new \ReflectionClass(get_class($this));
        foreach ($oModelRef->getMethods() as $method) {
            $this->_methods[] = $method->getName();
        }

        foreach ($oModelRef->getProperties() as $property) {
            if ($property->class === get_class($this))
                $this->_attributes[] = $property->getName();

            $this->_rules[$property->getName()] = $this->docStringToArray($property->getDocComment());
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
            if (in_array($attr, $this->_attributes) || $attr === '_id') {
                $attr = $attr === '_id' ? 'id' : $attr;

                if (isset($this->_rules[$attr]) && isset($this->_rules[$attr]['Type']) && $this->_rules[$attr]['Type'] === 'date') {
                    $value = is_array($value) ? new \DateTime($value['date']) : new \DateTime($value);
                }

                $this->{$attr} = $value;
            }
        }
    }

    public function getJSONified()
    {
        $oAttributes = $this->getAttributes();
        foreach ($oAttributes as $attr => $value) {
            if ($value instanceof \MongoId) {
                $oAttributes[$attr] = $value;
                continue;
            }

            if ($value instanceof \DateTime) {
                $oAttributes[$attr] = $value->format('Y-m-d H:i:s');
                continue;
            }

            $oAttributes[$attr] = $value;
        }

        return $oAttributes;
    }

    public function docStringToArray($docString)
    {
        if (!$docString)
            return [];

        $treatedDocString = [];
        preg_match_all('/\@(.*?)\((.*?)\)\n/', $docString, $matches);
        foreach ($matches[1] as $index => $configName) {
            $treatedDocString[$configName] = $matches[2][$index];
        }

        return $treatedDocString;
    }

    public function addError($attribute, $error) {
        if (!isset($this->_errors[$attribute]))
            $this->_errors[$attribute] = [];

        $this->_errors[$attribute][] = $error;
    }

    public function hasErrors()
    {
        return !empty($this->_errors);
    }

    public function getErrors($attribute = null)
    {
        if (!is_null($attribute) && isset($this->_errors[$attribute]))
            return $this->_errors[$attribute];

        return $this->_errors;
    }

    public function validate()
    {
        $this->_errors = [];

        foreach ($this->_rules as $attribute => $attributeRules) {
            if (isset($attributeRules['Default']) && empty($this->{$attribute}))
                $this->{$attribute} = $attributeRules['Default'];

            if (isset($attributeRules['Required']) && $attributeRules['Required'] && empty($this->{$attribute}))
                $this->addError($attribute, 'O preenchimento deste campo é obrigatório');

            if (isset($attributeRules['Type'])) {
                if ($attributeRules['Type'] === 'date') {
                    if ($this->{$attribute} instanceof \DateTime)
                        continue;

                    $this->{$attribute} = new \DateTime($this->{$attribute});
                    if (!$this->{$attribute})
                        $this->addError($attribute, "Data não válida");

                    continue;
                }
            }

            if (isset($attributeRules['MaxLength']) && strlen($this->{$attribute}) > $attributeRules['MaxLength'])
                $this->addError($attribute, "A quantidade máxima de caracteres permitida é de {$attributeRules['MaxLength']}");

            if (isset($attributeRules['MinLength']) && strlen($this->{$attribute}) < $attributeRules['MinLength'])
                $this->addError($attribute, "A quantidade minima de caracteres permitida é de {$attributeRules['MinLength']}");
        }

        return !$this->hasErrors();
    }

}