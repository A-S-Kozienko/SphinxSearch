<?php
namespace ASK\SphinxSearch\Logging;

use ASK\SphinxSearch\SphinxQuery;
use ASK\SphinxSearch\SphinxResult;

class SphinxLogger
{
    /**
     * @var array
     */
    protected $queries = array();

    /**
     * @var int
     */
    protected $queryIndex = -1;

    /**
     * @var float
     */
    protected $queryStart;

    /**
     * @param \ASK\SphinxSearch\SphinxQuery $query
     */
    public function startQuery(SphinxQuery $query)
    {
        $this->queries[++$this->queryIndex] = array(
            'query' => clone $query,
        );

        $this->queryStart = microtime(true);
    }

    /**
     * @param \ASK\SphinxSearch\SphinxResult $result
     */
    public function stopQuery(SphinxResult $result)
    {
        $this->queries[$this->queryIndex]['executionTime'] = microtime(true) - $this->queryStart;
        $this->queries[$this->queryIndex]['result'] = clone $result;
    }

    /**
     * @return array
     */
    public function getQueries()
    {
        return $this->queries;
    }
}
