<?php
namespace ASK\SphinxSearch\SphinxQL;

use ASK\SphinxSearch\SphinxQL\Driver\ConnectionInterface;

class SphinxSearch
{
    /**
     * @var \ASK\SphinxSearch\SphinxQL\Driver\ConnectionInterface
     */
    protected $connection;

    /**
     * @param \ASK\SphinxSearch\SphinxQL\Driver\ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function showStatus()
    {
        return $this->connection->query('SHOW STATUS');
    }
}