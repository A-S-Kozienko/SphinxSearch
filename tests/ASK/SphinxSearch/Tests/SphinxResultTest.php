<?php
namespace ASK\SphinxSearch\Tests;

use ASK\SphinxSearch\SphinxResult;

class SphinxResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function couldBeConstructed()
    {
        new SphinxResult(array());
    }

    /**
     * @test
     */
    public function shouldReturnMatches()
    {
        $originalResult = array(
            'matches' => array(1,2,3)
        );

        $result = new SphinxResult($originalResult);

        $this->assertSame($originalResult['matches'], $result->getMatches());
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenMatchesNotSet()
    {
        $result = new SphinxResult(array());

        $this->assertInternalType('array', $result->getMatches());
        $this->assertEmpty($result->getMatches());
    }

    /**
     * @test
     */
    public function shouldReturnTotal()
    {
        $originalResult = array(
            'total' => '1'
        );

        $result = new SphinxResult($originalResult);

        $this->assertInternalType('integer', $result->getTotal());
        $this->assertEquals(1, $result->getTotal());
    }

    /**
     * @test
     */
    public function shouldReturnZeroWhenTotalNotSet()
    {
        $result = new SphinxResult(array());

        $this->assertInternalType('integer', $result->getTotal());
        $this->assertEquals(0, $result->getTotal());
    }

    /**
     * @test
     */
    public function shouldReturnTotalFound()
    {
        $originalResult = array(
            'total_found' => '1'
        );

        $result = new SphinxResult($originalResult);

        $this->assertInternalType('integer', $result->getTotalFound());
        $this->assertEquals(1, $result->getTotalFound());
    }

    /**
     * @test
     */
    public function shouldReturnZeroWhenTotalFoundNotSet()
    {
        $result = new SphinxResult(array());

        $this->assertInternalType('integer', $result->getTotalFound());
        $this->assertEquals(0, $result->getTotalFound());
    }

    /**
     * @test
     */
    public function shouldReturnErrorMessage()
    {
        $originalResult = array(
            'error' => 'lorem ipsum',
        );

        $result = new SphinxResult($originalResult);

        $this->assertEquals($originalResult['error'], $result->getError());
    }

    /**
     * @test
     */
    public function shouldReturnEmptyStringWhenErrorNotSet()
    {
        $result = new SphinxResult(array());

        $this->assertInternalType('string', $result->getError());
        $this->assertEmpty($result->getError());
    }

    /**
     * @test
     */
    public function shouldReturnWarningMessage()
    {
        $originalResult = array(
            'warning' => 'lorem ipsum',
        );

        $result = new SphinxResult($originalResult);

        $this->assertEquals($originalResult['warning'], $result->getWarning());
    }

    /**
     * @test
     */
    public function shouldReturnEmptyStringWhenWarningNotSet()
    {
        $result = new SphinxResult(array());

        $this->assertInternalType('string', $result->getWarning());
        $this->assertEmpty($result->getWarning());
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfHasError()
    {
        $originalResult = array(
            'error' => 'lorem ipsum',
        );

        $result = new SphinxResult($originalResult);

        $this->assertTrue($result->hasError());
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfHasNoError()
    {
        $result = new SphinxResult(array());

        $this->assertFalse($result->hasError());
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfHasWarning()
    {
        $originalResult = array(
            'warning' => 'lorem ipsum',
        );

        $result = new SphinxResult($originalResult);

        $this->assertTrue($result->hasWarning());
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfHasNoWarning()
    {
        $result = new SphinxResult(array());

        $this->assertFalse($result->hasWarning());
    }

    /**
     * @test
     */
    public function shouldReturnStatus()
    {
        $originalResult = array(
            'status' => '1',
        );

        $result = new SphinxResult($originalResult);

        $this->assertInternalType('integer', $result->getStatus());
        $this->assertEquals(1, $result->getStatus());
    }

    /**
     * @test
     */
    public function shouldReturnZeroWhenStatusNotSet()
    {
        $result = new SphinxResult(array());

        $this->assertInternalType('integer', $result->getStatus());
        $this->assertEquals(0, $result->getStatus());
    }

    /**
     * @test
     */
    public function shouldReturnExecutionTime()
    {
        $originalResult = array(
            'time' => '1.01',
        );

        $result = new SphinxResult($originalResult);

        $this->assertInternalType('float', $result->getExecutionTime());
        $this->assertEquals(1.01, $result->getExecutionTime());
    }

    /**
     * @test
     */
    public function shouldReturnNullWhenExecutionTimeNotSet()
    {
        $result = new SphinxResult(array());

        $this->assertNull($result->getExecutionTime());
    }

    /**
     * @test
     */
    public function shouldReturnWords()
    {
        $originalResult = array(
            'words' => array(1,2,3),
        );

        $result = new SphinxResult($originalResult);

        $this->assertInternalType('array', $result->getWords());
        $this->assertEquals($originalResult['words'], $result->getWords());
    }

    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenWordsNotSet()
    {
        $result = new SphinxResult(array());

        $this->assertInternalType('array', $result->getWords());
        $this->assertEmpty($result->getWords());
    }
}