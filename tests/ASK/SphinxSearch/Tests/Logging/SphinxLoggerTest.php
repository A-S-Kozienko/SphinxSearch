<?php
namespace ASK\SphinxSearch\Tests\Logging;

use ASK\SphinxSearch\Logging\SphinxLogger;
use ASK\SphinxSearch\SphinxManager;
use ASK\SphinxSearch\SphinxQuery;
use ASK\SphinxSearch\SphinxResult;

class SphinxLoggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldLogQuery()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $logger = new SphinxLogger();

        //guard
        $this->assertInternalType('array', $logger->getQueries());
        $this->assertEmpty($logger->getQueries());

        //test
        $query = new SphinxQuery($manager, array());
        $result = new SphinxResult(array());

        $logger->startQuery($query);
        $logger->stopQuery($result);

        $queries = $logger->getQueries();

        $this->assertInternalType('array', $queries);
        $this->assertNotSame($query, $queries[0]['query']);
        $this->assertNotSame($result, $queries[0]['result']);
        $this->assertInstanceOf('ASK\\SphinxSearch\\SphinxQuery', $queries[0]['query']);
        $this->assertInstanceOf('ASK\\SphinxSearch\\SphinxResult', $queries[0]['result']);
        $this->assertArrayHasKey('executionTime', $queries[0]);
        $this->assertInternalType('float', $queries[0]['executionTime']);
    }
}
