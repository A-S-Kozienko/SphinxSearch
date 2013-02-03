<?php
namespace ASK\SphinxSearch\Tests\Query;

use ASK\SphinxSearch\SphinxQL\Query\Meta;

/**
 * MetaTest
 */
class MetaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldParseData()
    {
        $data =array(
            array(
                'Variable_name' => "total",
                'Value'         => "1",
            ),
            array(
                'Variable_name' => "total_found",
                'Value'         => "1",
            ),
            array(
                'Variable_name' => "time",
                'Value'         => "0.000",
            ),
            array(
                'Variable_name' => "keyword[0]",
                'Value'         => "text1",
            ),
            array(
                'Variable_name' => "docs[0]",
                'Value'         => "2",
            ),
            array(
                'Variable_name' => "hits[0]",
                'Value'         => "2",
            ),
            array(
                'Variable_name' => "keyword[1]",
                'Value'         => "text2",
            ),
            array(
                'Variable_name' => "docs[1]",
                'Value'         => "3",
            ),
            array(
                'Variable_name' => "hits[1]",
                'Value'         => "4",
            ),
        );

        $meta = new Meta($data);

        $this->assertInternalType('int', $meta->getTotal());
        $this->assertEquals(1, $meta->getTotal());
        $this->assertInternalType('int', $meta->getTotalFound());
        $this->assertEquals(1, $meta->getTotalFound());
        $this->assertInternalType('float', $meta->getExecutionTime());
        $this->assertEquals(0, $meta->getExecutionTime());

        $keywords = $meta->getKeywords();

        $this->assertEquals('text1', $keywords[0]['keyword']);
        $this->assertEquals(2, $keywords[0]['docs']);
        $this->assertEquals(2, $keywords[0]['hits']);

        $this->assertEquals('text2', $keywords[1]['keyword']);
        $this->assertEquals(3, $keywords[1]['docs']);
        $this->assertEquals(4, $keywords[1]['hits']);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldThrowInvalidArgumentIfDataLengthLessThanThree()
    {
        new Meta(array());
    }
}
