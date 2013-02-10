<?php
namespace ASK\SphinxSearch\SphinxQL\Logging;

use ASK\SphinxSearch\SphinxQL\Query\Meta;

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
     * @param \ASK\SphinxSearch\SphinxQL\Query\Meta $meta
     */
    public function stopQuery(Meta $meta)
    {
        $this->queries[$this->queryIndex]['executionTime'] = microtime(true) - $this->queryStart;
        $this->queries[$this->queryIndex]['meta'] = $meta;
    }

    /**
     * @return array
     */
    public function getQueries()
    {
        return $this->queries;
    }
}
