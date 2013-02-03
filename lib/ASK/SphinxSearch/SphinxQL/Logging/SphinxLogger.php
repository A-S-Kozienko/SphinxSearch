<?php
namespace ASK\SphinxSearch\SphinxQL\Logging;

use ASK\SphinxSearch\SphinxResult;

/**
 * SphinxLogger
 */
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
     * @param string $query
     */
    public function startQuery($query)
    {
        $this->queries[++$this->queryIndex] = array(
            'query' => $query,
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
