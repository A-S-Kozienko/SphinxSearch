<?php
namespace ASK\SphinxSearch;

class SphinxRequest
{
    /**
     * @var SphinxManager
     */
    private $manager;

    /**
     * @var array
     */
    private $queryParameters = array();

    /**
     * @var array
     */
    private $queries = array();

    /**
     * @var array
     */
    private $indexes;

    /**
     * @var int
     */
    private $maxResults = 10;

    /**
     * @var int
     */
    private $firstResult = 0;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var int
     */
    private $matchMode = SPH_MATCH_ALL;

    /**
     * @var array
     */
    private $filters = array();

    /**
     * @var array
     */
    private $rangeFilters = array();

    /**
     * @var array
     */
    private $floatRangeFilters = array();

    /**
     * @var array
     */
    private $groupBy;

    /**
     * @var string
     */
    private $groupDistinct = '';

    /**
     * @var array
     */
    private $sortMode;

    /**
     * @param SphinxManager $manager
     * @param array $indexes
     */
    public function __construct(SphinxManager $manager, array $indexes)
    {
        $this->manager      = $manager;
        $this->indexes      = $indexes;
    }

    /**
     * @return SphinxResult
     */
    public function execute()
    {
        return $this->manager->executeSingleRequest($this);
    }

    /**
     * @param string $comment
     *
     * @return SphinxRequest
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return array
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

    /**
     * @param string $query
     * @throws \InvalidArgumentException
     */
    public function addQuery($query)
    {
        if (false == is_string($query)) {
            throw new \InvalidArgumentException('query should be type of string');
        }

        $this->queries[] = $query;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return trim(implode(' ', $this->queries));
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return SphinxRequest
     */
    public function setQueryParameter($key, $value)
    {
        $this->queryParameters[$key] = $value;

        return $this;
    }

    /**
     * @param array $parameters
     *
     * @return SphinxRequest
     */
    public function setQueryParameters(array $parameters)
    {
        $this->queryParameters = $parameters;

        return $this;
    }

    /**
     * @return array
     */
    public function getQueryParameters()
    {
        return $this->queryParameters;
    }

    /**
     * Sets the position of the first result to retrieve (the "offset").
     *
     * @param integer $firstResult
     *
     * @return SphinxRequest
     */
    public function setFirstResult($firstResult)
    {
        $this->firstResult = $firstResult;

        return $this;
    }

    /**
     * Gets the position of the first result to retrieve (the "offset").
     *
     * @return int
     */
    public function getFirstResult()
    {
        return $this->firstResult;
    }

    /**
     * Sets the maximum number of results to retrieve (the "limit").
     *
     * @param int $maxResults
     *
     * @return SphinxRequest
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;

        return $this;
    }

    /**
     * Gets the maximum number of results to retrieve (the "limit").
     *
     * @return int
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * @param int $matchMode
     *
     * @return SphinxRequest
     */
    public function setMatchMode($matchMode)
    {
        $this->matchMode = $matchMode;

        return $this;
    }

    /**
     * @return int
     */
    public function getMatchMode()
    {
        return $this->matchMode;
    }

    /**
     * @param string $attribute
     * @param int|array $values
     * @param bool $exclude
     *
     * @return SphinxRequest
     */
    public function addFilter($attribute, $values, $exclude=false)
    {
        $this->filters[] = array(
            'attribute' => $attribute,
            'values'    => is_array($values) ? $values : (array) $values,
            'exclude'   => $exclude,
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param string $attribute
     * @param numeric $min
     * @param numeric $max
     * @param bool $exclude
     *
     * @return SphinxRequest
     */
    public function addFilterRange($attribute, $min, $max, $exclude = false)
    {
        $this->rangeFilters[] = array(
            'attribute' => $attribute,
            'min'       => $min,
            'max'       => $max,
            'exclude'   => $exclude,
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getRangeFilters()
    {
        return $this->rangeFilters;
    }

    /**
     * @param string $attribute
     * @param numeric $min
     * @param numeric $max
     * @param bool $exclude
     *
     * @return SphinxRequest
     */
    public function addFilterFloatRange($attribute, $min, $max, $exclude = false)
    {
        $this->floatRangeFilters[] = array(
            'attribute' => $attribute,
            'min'       => $min,
            'max'       => $max,
            'exclude'   => $exclude,
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getFloatRangeFilters()
    {
        return $this->floatRangeFilters;
    }

    /**
     * @param string $attribute
     * @param int $func
     * @param string $groupsort
     *
     * @return SphinxRequest
     */
    public function setGroupBy($attribute, $func, $groupsort="@group desc")
    {
        $this->groupBy = array(
            'attribute' => $attribute,
            'func'      => $func,
            'groupsort' => $groupsort,
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * @param string $attribute
     *
     * @return SphinxRequest
     */
    public function setGroupDistinct($attribute)
    {
        $this->groupDistinct = $attribute;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroupDistinct()
    {
        return $this->groupDistinct;
    }

    /**
     * @param int $mode
     * @param string $sortBy
     *
     * @return SphinxRequest
     */
    public function setSortMode($mode, $sortBy = "")
    {
        $this->sortMode = array(
            'mode'      => $mode,
            'sortBy'    => $sortBy,
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getSortMode()
    {
        return $this->sortMode;
    }
}