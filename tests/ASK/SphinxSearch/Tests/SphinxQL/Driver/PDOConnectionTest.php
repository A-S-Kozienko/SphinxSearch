<?php
namespace ASK\SphinxSearch\Tests\SphinxQL\Driver;

use ASK\SphinxSearch\SphinxQL\Driver\PDOConnection;

class PDOConnectionTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $_ENV['SPHINX_HOST'] = '127.0.0.1';
        $_ENV['SPHINX_PORT'] = 9306;
    }

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
    public function should()
    {
        $connection = new PDOConnection($_ENV['SPHINX_HOST'], $_ENV['SPHINX_PORT']);
        var_dump($connection->query('SELECT id FROM mt_unit_main_dev'));
    }
}
