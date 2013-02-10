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
    public function shouldReturnNullIfNoWarnings()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
        $sphinxSearch = new SphinxSearch($connection);

        $this->assertNull($sphinxSearch->showWarnings());
    }

    /**
     * @test
     */
    public function shouldReturnWarning()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
        $sphinxSearch = new SphinxSearch($connection);

        $connection->query('SELECT * FROM test WHERE MATCH(\'"test doc"/3\')');

        $expected = array(
            'message' => 'quorum threshold too high (words=2, thresh=3); replacing quorum operator with AND operator',
            'code'    => '1000',
        );

        $this->assertSame($expected, $sphinxSearch->showWarnings());
    }

    /**
     * @test
     */
    public function shouldShowMeta()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
        $sphinxSearch = new SphinxSearch($connection);

        $sphinxSearch->query("SELECT * FROM test WHERE MATCH('text1 text2')");
        $result = $sphinxSearch->showMeta();

        $this->assertInstanceOf('ASK\SphinxSearch\SphinxQL\Query\Meta', $result);
        $this->assertEquals(1, $result->getTotal());
        $this->assertEquals(1, $result->getTotalFound());
        $this->assertEquals(0, $result->getExecutionTime());

        $keywords = $result->getKeywords();

        $this->assertEquals('text1', $keywords[0]['keyword']);
        $this->assertEquals(2, $keywords[0]['docs']);
        $this->assertEquals(2, $keywords[0]['hits']);

        $this->assertEquals('text2', $keywords[1]['keyword']);
        $this->assertEquals(2, $keywords[1]['docs']);
        $this->assertEquals(2, $keywords[1]['hits']);
    }
}
