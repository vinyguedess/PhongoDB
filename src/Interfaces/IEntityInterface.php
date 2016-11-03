<?php

namespace PhongoDB\Interfaces;


interface IEntityInterface {

    public function getCollection();

    public function getAttributes();

    public function setAttributes($attributes);

    public function validate();

}
