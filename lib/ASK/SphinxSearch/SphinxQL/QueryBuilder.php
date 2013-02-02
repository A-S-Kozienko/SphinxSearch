<?php
namespace ASK\SphinxSearch\SphinxQL;

/**
 * QueryBuilder
 */
class QueryBuilder
{
    const ORDER_ASC                                         = 'ASC';

    const ORDER_DESC                                        = 'DESC';

    const RANKER_PROXIMITY_BM25                             = 'proximity_bm25';

    const RANKER_BM25                                       = 'bm25';

    const RANKER_NONE                                       = 'none';

    const RANKER_WORD_COUNT                                 = 'wordcount';

    const RANKER_PROXIMITY                                  = 'proximity';

    const RANKER_MATCH_ANY                                  = 'matchany';

    const RANKER_FIELD_MASK                                 = 'fieldmask';

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

    /**
     * @var string
     */
    protected $groupBy;

    /**
     * @var array
     */
    protected $orderBy = array();

    /**
     * @var array
     */
    protected $withinGroupOrderBy;

    /**
     * @var array
     */
    protected $limit;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var array
     */
    protected $optionsList = array();

    /**
     * @var string
     */
    protected $comment;

    /**
     * @param string $expr
     *
     * @return $this
     */
    public function select($expr)
    {
        $this->select = array($expr);

        return $this;
    }

    /**
     * @param string $expr
     *
     * @return $this
     */
    public function addSelect($expr)
    {
        $this->select[] = $expr;

        return $this;
    }

    /**
     * @param string $index
     *
     * @return $this
     */
    public function from($index)
    {
        $this->from = array($index);

        return $this;
    }

    /**
     * @param string $index
     *
     * @return $this
     */
    public function addFrom($index)
    {
        $this->from[] = $index;

        return $this;
    }

    /**
     * @param string $condition
     *
     * @return $this
     */
    public function where($condition)
    {
        $this->where = array($condition);

        return $this;
    }

    /**
     * @param string $condition
     *
     * @return $this
     */
    public function addWhere($condition)
    {
        $this->where[] = $condition;

        return $this;
    }

    /**
     * @param array $parameters
     *
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @param string $column
     *
     * @return $this
     */
    public function groupBy($column)
    {
        $this->groupBy = $column;

        return $this;
    }

    /**
     * @param string $column
     * @param string $order
     *
     * @return $this
     */
    public function orderBy($column, $order = self::ORDER_ASC)
    {
        $this->orderBy = array(array($column, $order));

        return $this;
    }

    /**
     * @param string $column
     * @param string $order
     *
     * @return $this
     */
    public function addOrderBy($column, $order = self::ORDER_ASC)
    {
        $this->orderBy[] = array($column, $order);

        return $this;
    }

    /**
     * @param string $column
     * @param string $order
     *
     * @return $this
     */
    public function withinGroupOrderBy($column, $order = self::ORDER_ASC)
    {
        $this->withinGroupOrderBy = array($column, $order);

        return $this;
    }

    /**
     * @param int $count
     * @param int $offset
     *
     * @return $this
     */
    public function limit($count, $offset = 0)
    {
        $this->limit = array((int) $offset, (int) $count);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setRanker($value)
    {
        $this->options['ranker'] = $value;

        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setMaxMatches($value)
    {
        $this->options['max_matches'] = $value;

        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setCutoff($value)
    {
        $this->options['cutoff'] = $value;

        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setMaxQueryTime($value)
    {
        $this->options['max_query_time'] = $value;

        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setRetryCount($value)
    {
        $this->options['retry_count'] = $value;

        return $this;
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setRetryDelay($value)
    {
        $this->options['retry_delay'] = $value;

        return $this;
    }

    /**
     * @param bool $reverseScan
     *
     * @return $this
     */
    public function setReverseScan($reverseScan)
    {
        $this->options['reverse_scan'] = $reverseScan ? 1 : 0;

        return $this;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function setFieldWeights(array $values)
    {
        $this->optionsList['field_weights'] = $values;

        return $this;
    }

    /**
     * @param string $field
     * @param int    $weight
     *
     * @return $this
     */
    public function addFieldWeight($field, $weight)
    {
        if (false == isset($this->optionsList['field_weights'])) {
            $this->optionsList['field_weights'] = array();
        }

        $this->optionsList['field_weights'][$field] = $weight;

        return $this;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function setIndexWeights(array $values)
    {
        $this->optionsList['index_weights'] = $values;

        return $this;
    }

    /**
     * @param string $index
     * @param int    $weight
     *
     * @return $this
     */
    public function addIndexWeight($index, $weight)
    {
        if (false == isset($this->optionsList['index_weights'])) {
            $this->optionsList['index_weights'] = array();
        }

        $this->optionsList['index_weights'][$index] = $weight;

        return $this;
    }

    /**
     * @param string $comment
     *
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
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

        if ($this->groupBy) {
            $sphinxQl .= ' GROUP BY ' . $this->groupBy;
        }

        if ($this->orderBy) {
            $options = array();
            foreach ($this->orderBy as $orderBy) {
                $options[] .= $orderBy[0] . ' ' . $orderBy[1];
            }

            $sphinxQl .= ' ORDER BY ' . implode(', ', $options);
        }

        if ($this->withinGroupOrderBy) {
            $sphinxQl .= ' WITHIN GROUP ORDER BY ' . implode(' ', $this->withinGroupOrderBy);
        }

        if ($this->limit) {
            $sphinxQl .= ' LIMIT ' . implode(', ', $this->limit);
        }

        $options = array();

        if ($this->options) {
            foreach ($this->options as $name => $value) {
                $options[] = $name . '=' . $value;
            }
        }

        if ($this->optionsList) {
            foreach ($this->optionsList as $optionName => $optionValue) {
                $weights = array();
                foreach ($optionValue as $field => $weight) {
                    $weights[] = $field . '=' . $weight;
                }

                $options[] = $optionName . '=(' . implode(', ', $weights) . ')';
            }
        }

        if ($this->comment) {
            $options[] = "comment='" . str_replace("'", "\\'", $this->comment) . "'";
        }

        if ($options) {
            $sphinxQl .= ' OPTION ' . implode(', ', $options);
        }

        return $sphinxQl;
    }
}