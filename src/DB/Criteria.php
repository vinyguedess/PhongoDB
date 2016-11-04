<?php

namespace PhongoDB\DB;


class Criteria
{

    private $where = [];
    private $limit = null;
    private $offset = null;

    const WAND = "\$and";
    const WOR = "\$or";
    const LT = "\$lt";
    const LTE = "\$lte";
    const EQ = "\$eq";
    const GTE = "\$gte";
    const GT = "\$gt";
    const LIKE = "\$regex";

    public function getWhere()
    {
        return $this->where;
    }

    public function where()
    {
        $args = func_get_args();
        if (count($args) < 1)
            return $this;

        if (count($args) == 2)
            return $this->where($args[0], self::EQ, $args[1]);

        if (count($args) >= 3) {
            $type = isset($args[3]) ? $args[3] : self::WAND;

            if (!isset($this->where[$type]))
                $this->where[$type] = [];

            if (!isset($this->where[$type][$args[0]]))
                $this->where[$type] = [];

            if ($args[1] === self::EQ)
                $fieldFilter = [$args[0] => $args[2]];
            else
                $fieldFilter = [$args[0] => [$args[1] => $args[2]]];
            if ($args[1] === self::LIKE)
                $fieldFilter[$args[0]]['$options'] = 'i';

            $this->where[$type][] = $fieldFilter;
        }

        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    public static function getInstance()
    {
        return new self();
    }

}
