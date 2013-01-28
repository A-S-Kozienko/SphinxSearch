<?php
namespace ASK\SphinxSearch\SphinxQL\Driver;

interface ConnectionInterface
{
    public function query($statement);
}