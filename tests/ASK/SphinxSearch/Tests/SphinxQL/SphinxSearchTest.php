<?php
namespace ASK\SphinxSearch\Tests\SphinxQL;

use ASK\SphinxSearch\SphinxQL\Driver\PDOConnection;
use ASK\SphinxSearch\SphinxQL\SphinxSearch;

class SphinxSearchTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $_ENV['SPHINX_HOST'] = '127.0.0.1';
        $_ENV['SPHINX_PORT'] = 9306;
    }

    /**
     * @test
     */
    public function shouldShowStatus()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
        $sphinxSearch = new SphinxSearch($connection);
        $result = $sphinxSearch->showStatus();

        $this->assertInternalType('array', $result);
        var_dump($result);
    }
}
