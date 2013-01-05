<?php
namespace ASK\SphinxSearch\Pagerfanta\Adapter;

use Pagerfanta\Adapter\AdapterInterface;
use ASK\SphinxSearch\SphinxQuery;

class SphinxAdapter implements AdapterInterface
{
    /**
     * @var \ASK\SphinxSearch\SphinxQuery
     */
    protected $request;

    /**
     * @var int
     */
    protected $maxMatches;

    /**
     * @var int
     */
    protected $cutOff;

    /**
     * @param \ASK\SphinxSearch\SphinxQuery $request
     * @param int $maxMatches
     * @param int $cutOff
     */
    public function __construct(SphinxQuery $request, $maxMatches = 0, $cutOff = 0)
    {
        $this->request      = $request;
        $this->maxMatches   = $maxMatches;
        $this->cutOff       = $cutOff;
    }

    /**
     * {@inheritDoc}
     */
    function getSlice($offset, $length)
    {
        $this->request->setLimits($offset, $length, $this->maxMatches, $this->cutOff);
        return $this->request->execute();
    }

    /**
     * {@inheritDoc}
     */
    function getNbResults()
    {
        return $this->request->execute()->getTotalFound();
    }
}