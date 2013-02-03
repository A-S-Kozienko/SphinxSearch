<?php
namespace ASK\SphinxSearch\SphinxQL\Driver;

/**
 * ConnectionInterface
 */
interface ConnectionInterface
{
    /**
     * @param string $statement
     *
     * @return array
     *
     * @throws \ASK\SphinxSearch\SphinxQL\Exception\SphinxException
     */
    public function query($statement);
}