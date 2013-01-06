<?php
namespace ASK\SphinxSearch\Pagerfanta\Adapter;

use Pagerfanta\Adapter\AdapterInterface;
use ASK\SphinxSearch\SphinxQuery;

class SphinxAdapter implements AdapterInterface
{
    /**
     * @var \ASK\SphinxSearch\SphinxQuery
     */
    protected $query;

    /**
     * @var int
     */
    protected $maxMatches;

    /**
     * @var int
     */
    protected $cutOff;

    /**
     * @param \ASK\SphinxSearch\SphinxQuery $query
     * @param int $maxMatches
     * @param int $cutOff
     */
    public function __construct(SphinxQuery $query, $maxMatches = 0, $cutOff = 0)
    {
        $this->query        = $query;
        $this->maxMatches   = $maxMatches;
        $this->cutOff       = $cutOff;
    }

    /**
     * {@inheritDoc}
     */
    function getSlice($offset, $length)
    {
        $this->query->setLimits($offset, $length, $this->maxMatches, $this->cutOff);
        return $this->query->execute();
    }

    /**
     * {@inheritDoc}
     */
    function getNbResults()
    {
        $this->query->setLimits(0, 1, $this->maxMatches, $this->cutOff);
        return $this->query->execute()->getTotalFound();
    }
}