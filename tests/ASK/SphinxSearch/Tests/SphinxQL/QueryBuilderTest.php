<?php
namespace ASK\SphinxSearch\Tests\SphinxQL;

use ASK\SphinxSearch\SphinxQL\QueryBuilder;

/**
 * QueryBuilderTest
 */
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
    public function shouldSetWhere()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->where('condition');

        $this->assertEquals('SELECT expr FROM index WHERE condition', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetGroupBy()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->groupBy('group_by');

        $this->assertEquals('SELECT expr FROM index GROUP BY group_by', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetSingleOrderBy()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->orderBy('column', 'DESC');

        $this->assertEquals('SELECT expr FROM index ORDER BY column DESC', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetMultipleOrderBy()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->orderBy('column', 'DESC')
            ->addOrderBy('column2', 'ASC');

        $this->assertEquals('SELECT expr FROM index ORDER BY column DESC, column2 ASC', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetWithinGroupOrderBy()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->withinGroupOrderBy('column', 'DESC');

        $this->assertEquals('SELECT expr FROM index WITHIN GROUP ORDER BY column DESC', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetLimitWithoutOffset()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->limit(10);

        $this->assertEquals('SELECT expr FROM index LIMIT 0, 10', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetLimitWithOffset()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->limit(10, 100);

        $this->assertEquals('SELECT expr FROM index LIMIT 100, 10', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetOptionRanker()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setRanker(QueryBuilder::RANKER_BM25);

        $this->assertEquals('SELECT expr FROM index OPTION ranker=bm25', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetOptionMaxMatches()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setMaxMatches(100);

        $this->assertEquals('SELECT expr FROM index OPTION max_matches=100', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetOptionCutoff()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setCutoff(100);

        $this->assertEquals('SELECT expr FROM index OPTION cutoff=100', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetOptionMaxQueryTime()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setMaxQueryTime(100);

        $this->assertEquals('SELECT expr FROM index OPTION max_query_time=100', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetOptionRetryCount()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setRetryCount(100);

        $this->assertEquals('SELECT expr FROM index OPTION retry_count=100', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetOptionRetryDelay()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setRetryDelay(100);

        $this->assertEquals('SELECT expr FROM index OPTION retry_delay=100', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetOptionFieldWeights()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setFieldWeights(array(
                'field'  => 1,
                'field2' => 2,
            ));

        $this->assertEquals('SELECT expr FROM index OPTION field_weights=(field=1, field2=2)', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldAddOptionFieldWeight()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->addFieldWeight('field', 1)
            ->addFieldWeight('field2', 2);

        $this->assertEquals('SELECT expr FROM index OPTION field_weights=(field=1, field2=2)', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetOptionIndexWeights()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setIndexWeights(array(
                'field'  => 1,
                'field2' => 2,
            ));

        $this->assertEquals('SELECT expr FROM index OPTION index_weights=(field=1, field2=2)', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldAddOptionIndexWeight()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->addIndexWeight('field', 1)
            ->addIndexWeight('field2', 2);

        $this->assertEquals('SELECT expr FROM index OPTION index_weights=(field=1, field2=2)', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetOptionReverseScan()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setReverseScan(true);

        $this->assertEquals('SELECT expr FROM index OPTION reverse_scan=1', $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetOptionComment()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setComment("comment'comment");

        $this->assertEquals("SELECT expr FROM index OPTION comment='comment\'comment'", $qb->getSphinxQL());
    }

    /**
     * @test
     */
    public function shouldSetMultiplyOptions()
    {
        $qb = new QueryBuilder();
        $qb->select('expr')
            ->from('index')
            ->setRetryCount(1)
            ->setRetryDelay(2)
            ->setFieldWeights(array(
                'field' => 3,
                'field2' => 4,
            ));

        $this->assertEquals("SELECT expr FROM index OPTION retry_count=1, retry_delay=2, field_weights=(field=3, field2=4)", $qb->getSphinxQL());
    }
}
