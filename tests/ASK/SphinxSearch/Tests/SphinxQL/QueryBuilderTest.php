<?php
namespace ASK\SphinxSearch\Tests\SphinxQL;


use ASK\SphinxSearch\SphinxQL\QueryBuilder;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function couldBeConstructed()
    {
        new QueryBuilder();
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Query select part is required
     */
    public function shouldThrowExceptionIfSelectNotSet()
    {
        $qb = new QueryBuilder();
        $qb->getSphinxQL();
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Query from part is required
     */
    public function shouldThrowExceptionIfFromNotSet()
    {
        $qb = new QueryBuilder();
        $qb->select('expr');
        $qb->getSphinxQL();
    }

    /**
     * @test
     */
    public function shouldReturnSphinxQL()
    {
        $qb = new QueryBuilder();
        $qb->select('expr');
        $qb->from('index');

        $this->assertEquals('SELECT expr FROM index', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldReturnSphinxQLWithWhere()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->where('condition')
        ;

        $this->assertEquals('SELECT expr FROM index WHERE condition', $qb->getSphinxQL());
    }
}
