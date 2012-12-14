<?php
namespace ASK\SphinxSearch\Pagerfanta\Adapter;

use Pagerfanta\Adapter\AdapterInterface;
use ASK\SphinxSearch\SphinxRequest;

class SphinxAdapter implements AdapterInterface
{
    /**
     * @var \ASK\SphinxSearch\SphinxRequest
     */
    protected $request;

    /**
     * @param \ASK\SphinxSearch\SphinxRequest $request
     */
    public function __construct(SphinxRequest $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    function getSlice($offset, $length)
    {
        $this->request->setFirstResult($offset);
        $this->request->setMaxResults($length);

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