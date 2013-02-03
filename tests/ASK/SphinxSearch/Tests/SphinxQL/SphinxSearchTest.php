<?php
namespace ASK\SphinxSearch\Tests\SphinxQL;

use ASK\SphinxSearch\SphinxQL\Driver\PDOConnection;
use ASK\SphinxSearch\SphinxQL\SphinxSearch;

/**
 * SphinxSearchTest
 */
class SphinxSearchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldShowStatus()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
        $sphinxSearch = new SphinxSearch($connection);
        $result = $sphinxSearch->showStatus();

        $this->assertInternalType('array', $result);
    }

    /**
     * @test
     */
    public function shouldDoQuery()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
        $sphinxSearch = new SphinxSearch($connection);

        $result = $sphinxSearch->query('SELECT * FROM test WHERE id = 1');
        $this->assertCount(1, $result);
        $this->assertEquals(1, $result[0]['id']);
        $this->assertEquals(1, $result[0]['weight']);
    }

    /**
     * @test
     * @expectedException \ASK\SphinxSearch\SphinxQL\Exception\SphinxErrorException
     * @expectedExceptionMessage sphinxql: syntax error, unexpected $end, expecting BETWEEN (or 8 other tokens) near 'MATCHHHH
     * @expectedExceptionCode 1064
     */
    public function shouldThrowSphinxError()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
        $sphinxSearch = new SphinxSearch($connection);

        $sphinxSearch->query('SELECT * FROM test WHERE MATCHHHH');
    }

    /**
     * @test
     * @expectedException \ASK\SphinxSearch\SphinxQL\Exception\SphinxWarningException
     * @expectedExceptionMessage quorum threshold too high (words=2, thresh=3); replacing quorum operator with AND operator
     * @expectedExceptionCode 1000
     */
    public function shouldThrowSphinxWarning()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
        $sphinxSearch = new SphinxSearch($connection);

        $sphinxSearch->query('SELECT * FROM test WHERE MATCH(\'"test doc"/3\')');
    }

    /**
     * @test
     */
    public function shouldShowMeta()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
        $sphinxSearch = new SphinxSearch($connection);

        $result = $sphinxSearch->showMeta();
    }
}
