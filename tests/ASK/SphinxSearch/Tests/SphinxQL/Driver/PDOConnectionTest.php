<?php
namespace ASK\SphinxSearch\Tests\SphinxQL\Driver;

use ASK\SphinxSearch\SphinxQL\Driver\PDOConnection;
use ASK\SphinxSearch\SphinxQL\Exception\SphinxErrorException;

/**
 * PDOConnectionTest
 */
class PDOConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function couldBeConstructed()
    {
        new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
    }

    /**
     * @test
     */
    public function shouldDoQuery()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);

        $result = $connection->query('SELECT id FROM test WHERE id = 1');

        $this->assertCount(1, $result);
        $this->assertEquals(1, $result[0]['id']);
        $this->assertEquals(1, $result[0]['weight']);
    }

    /**
     * @test
     * @expectedException \ASK\SphinxSearch\SphinxQL\Exception\SphinxErrorException
     * @expectedExceptionMessage index test: no such filter attribute 'invalid_attribute'
     */
    public function shouldThrowSphinxErrorWhenErrorOccurred()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);

        $connection->query('SELECT id FROM test WHERE invalid_attribute = 1');
    }
}
