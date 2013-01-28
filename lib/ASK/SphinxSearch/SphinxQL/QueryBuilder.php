<?php
namespace ASK\SphinxSearch\SphinxQL;

class QueryBuilder
{
    /**
     * @var array
     */
    protected $select = array();

    /**
     * @var array
     */
    protected $from = array();

    /**
     * @var array
     */
    protected $where = array();

    /**
     * @var array
     */
    protected $parameters = array();

    public function select($expr)
    {
        $this->select = array($expr);

        return $this;
    }

    public function addSelect($expr)
    {
        $this->select[] = $expr;

        return $this;
    }

    public function from($index)
    {
        $this->from = array($index);

        return $this;
    }

    public function addFrom($index)
    {
        $this->from[] = $index;

        return $this;
    }

    public function where($condition)
    {
        $this->where = array($condition);

        return $this;
    }

    public function addWhere($condition)
    {
        $this->where[] = $condition;

        return $this;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public function getSphinxQL()
    {
        if (false == $this->select) {
            throw new \InvalidArgumentException('Query select part is required');
        }

        if (false == $this->from) {
            throw new \InvalidArgumentException('Query from part is required');
        }

        $sphinxQl = 'SELECT ' . implode(', ', $this->select)
            . ' FROM ' . implode(', ', $this->from);

        if ($this->where) {
            $sphinxQl .= ' WHERE ' . implode(' ', $this->where);
        }

        return $sphinxQl;
    }
}