<?php
namespace ASK\SphinxSearch\Tests;

use ASK\SphinxSearch\SphinxManager;
use ASK\SphinxSearch\SphinxQLFormatter;
use ASK\SphinxSearch\SphinxQuery;

class SphinxQLFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldFormatFrom()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('FROM index1, index2', $formatter->formatFrom($query));
    }

    /**
     * @test
     */
    public function shouldFormatLimits()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->setLimits(10, 2345);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('LIMIT 10, 2345', $formatter->formatLimit($query));
    }

    /**
     * @test
     */
    public function shouldFormatFiltersWithOneValue()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addFilter('attribute', 5);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute = 5', $formatter->formatFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatFiltersWithOneExcludeValue()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addFilter('attribute', 5, true);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute != 5', $formatter->formatFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatFiltersWithManyValues()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addFilter('attribute', array(5,6,7));

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute IN (5,6,7)', $formatter->formatFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatFiltersWithExcludeManyValues()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addFilter('attribute', array(5,6,7), true);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute NOT IN (5,6,7)', $formatter->formatFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatManyFilters()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addFilter('attribute1', 1);
        $query->addFilter('attribute2', 2);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute1 = 1 AND attribute2 = 2', $formatter->formatFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatRangeFilter()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addRangeFilter('attribute', 5, 10);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute BETWEEN 5 AND 10', $formatter->formatRangeFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatExcludeRangeFilter()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addRangeFilter('attribute', 5, 10, true);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute NOT BETWEEN 5 AND 10', $formatter->formatRangeFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatManyRangeFilters()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addRangeFilter('attribute1', 5, 10);
        $query->addRangeFilter('attribute2', 6, 9);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute1 BETWEEN 5 AND 10 AND attribute2 BETWEEN 6 AND 9', $formatter->formatRangeFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatFloatRangeFilter()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addFloatRangeFilter('attribute', 5.1, 10.2);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute BETWEEN 5.1 AND 10.2', $formatter->formatFloatRangeFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatExcludeFloatRangeFilter()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addFloatRangeFilter('attribute', 5.1, 10.2, true);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute NOT BETWEEN 5.1 AND 10.2', $formatter->formatFloatRangeFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatManyFloatRangeFilters()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addFloatRangeFilter('attribute1', 5.1, 10.2);
        $query->addFloatRangeFilter('attribute2', 6.3, 9.4);

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('attribute1 BETWEEN 5.1 AND 10.2 AND attribute2 BETWEEN 6.3 AND 9.4', $formatter->formatFloatRangeFilters($query));
    }

    /**
     * @test
     */
    public function shouldFormatMatches()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->addMatch('word1');
        $query->addMatch('word2');

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('MATCH(\'word1 word2\')', $formatter->formatMatch($query));
    }

    /**
     * @test
     */
    public function shouldFormatOrderBy()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));
        $query->setSortMode(SPH_SORT_EXTENDED, 'attribute DESC');

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('ORDER BY attribute DESC', $formatter->formatOrderBy($query));
    }

    /**
     * @test
     */
    public function formatOrderByShouldReturnEmptyStringWhenSortingNotSet()
    {
        $manager = new SphinxManager(new \SphinxClient());
        $query = new SphinxQuery($manager, array('index1', 'index2'));

        $formatter = new SphinxQLFormatter();
        $this->assertEquals('', $formatter->formatOrderBy($query));
    }
}
