<?php
namespace ASK\SphinxSearch\Tests;

use ASK\SphinxSearch\SphinxStatus;

class SphinxStatusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnUptime()
    {
        $status = new SphinxStatus(array(
            array('uptime', '5')
        ));

        $this->assertInternalType('int', $status->getUptime());
        $this->assertEquals(5, $status->getUptime());
    }

    /**
     * @test
     */
    public function shouldReturnConnections()
    {
        $status = new SphinxStatus(array(
            array('connections', '5')
        ));

        $this->assertInternalType('int', $status->getConnections());
        $this->assertEquals(5, $status->getConnections());
    }

    /**
     * @test
     */
    public function shouldReturnMaxedOut()
    {
        $status = new SphinxStatus(array(
            array('maxed_out', '5')
        ));

        $this->assertInternalType('int', $status->getMaxedOut());
        $this->assertEquals(5, $status->getMaxedOut());
    }

    /**
     * @test
     */
    public function shouldReturnCommandSearch()
    {
        $status = new SphinxStatus(array(
            array('command_search', '5')
        ));

        $this->assertInternalType('int', $status->getCommandSearch());
        $this->assertEquals(5, $status->getCommandSearch());
    }

    /**
     * @test
     */
    public function shouldReturnCommandExcerpt()
    {
        $status = new SphinxStatus(array(
            array('command_excerpt', '5')
        ));

        $this->assertInternalType('int', $status->getCommandExcerpt());
        $this->assertEquals(5, $status->getCommandExcerpt());
    }

    /**
     * @test
     */
    public function shouldReturnCommandUpdate()
    {
        $status = new SphinxStatus(array(
            array('command_update', '5')
        ));

        $this->assertInternalType('int', $status->getCommandUpdate());
        $this->assertEquals(5, $status->getCommandUpdate());
    }

    /**
     * @test
     */
    public function shouldReturnCommandKeywords()
    {
        $status = new SphinxStatus(array(
            array('command_keywords', '5')
        ));

        $this->assertInternalType('int', $status->getCommandKeywords());
        $this->assertEquals(5, $status->getCommandKeywords());
    }

    /**
     * @test
     */
    public function shouldReturnCommandPersist()
    {
        $status = new SphinxStatus(array(
            array('command_persist', '5')
        ));

        $this->assertInternalType('int', $status->getCommandPersist());
        $this->assertEquals(5, $status->getCommandPersist());
    }

    /**
     * @test
     */
    public function shouldReturnCommandStatus()
    {
        $status = new SphinxStatus(array(
            array('command_status', '5')
        ));

        $this->assertInternalType('int', $status->getCommandStatus());
        $this->assertEquals(5, $status->getCommandStatus());
    }

    /**
     * @test
     */
    public function shouldReturnCommandFlushAttributes()
    {
        $status = new SphinxStatus(array(
            array('command_flushattrs', '5')
        ));

        $this->assertInternalType('int', $status->getCommandFlushAttributes());
        $this->assertEquals(5, $status->getCommandFlushAttributes());
    }

    /**
     * @test
     */
    public function shouldReturnQueryCpu()
    {
        $status = new SphinxStatus(array(
            array('query_cpu', '5')
        ));

        $this->assertInternalType('float', $status->getQueryCpu());
        $this->assertEquals(5, $status->getQueryCpu());
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfQueryCpuNotNumeric()
    {
        $status = new SphinxStatus(array(
            array('query_cpu', 'OFF')
        ));

        $this->assertFalse($status->getQueryCpu());
    }

    /**
     * @test
     */
    public function shouldReturnQueryReads()
    {
        $status = new SphinxStatus(array(
            array('query_reads', '5')
        ));

        $this->assertInternalType('float', $status->getQueryReads());
        $this->assertEquals(5, $status->getQueryReads());
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfQueryReadsNotNumeric()
    {
        $status = new SphinxStatus(array(
            array('query_reads', 'OFF')
        ));

        $this->assertFalse($status->getQueryReads());
    }

    /**
     * @test
     */
    public function shouldReturnQueryReadKb()
    {
        $status = new SphinxStatus(array(
            array('query_readkb', '5')
        ));

        $this->assertInternalType('float', $status->getQueryReadKb());
        $this->assertEquals(5, $status->getQueryReadKb());
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfQueryReadKbNotNumeric()
    {
        $status = new SphinxStatus(array(
            array('query_readkb', 'OFF')
        ));

        $this->assertFalse($status->getQueryReadKb());
    }

    /**
     * @test
     */
    public function shouldReturnQueryReadTime()
    {
        $status = new SphinxStatus(array(
            array('query_readtime', '5')
        ));

        $this->assertInternalType('float', $status->getQueryReadTime());
        $this->assertEquals(5, $status->getQueryReadTime());
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfQueryReadTimeNotNumeric()
    {
        $status = new SphinxStatus(array(
            array('query_readtime', 'OFF')
        ));

        $this->assertFalse($status->getQueryReadTime());
    }

    /**
     * @test
     */
    public function shouldReturnAverageQueryCpu()
    {
        $status = new SphinxStatus(array(
            array('avg_query_cpu', '5')
        ));

        $this->assertInternalType('float', $status->getAverageQueryCpu());
        $this->assertEquals(5, $status->getAverageQueryCpu());
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfAverageQueryCpuNotNumeric()
    {
        $status = new SphinxStatus(array(
            array('avg_query_cpu', 'OFF')
        ));

        $this->assertFalse($status->getAverageQueryCpu());
    }

    /**
     * @test
     */
    public function shouldReturnAverageQueryReads()
    {
        $status = new SphinxStatus(array(
            array('avg_query_reads', '5')
        ));

        $this->assertInternalType('float', $status->getAverageQueryReads());
        $this->assertEquals(5, $status->getAverageQueryReads());
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfAverageQueryReadsNotNumeric()
    {
        $status = new SphinxStatus(array(
            array('avg_query_reads', 'OFF')
        ));

        $this->assertFalse($status->getAverageQueryReads());
    }

    /**
     * @test
     */
    public function shouldReturnAverageQueryReadKb()
    {
        $status = new SphinxStatus(array(
            array('avg_query_readkb', '5')
        ));

        $this->assertInternalType('float', $status->getAverageQueryReadKb());
        $this->assertEquals(5, $status->getAverageQueryReadKb());
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfAverageQueryReadKbNotNumeric()
    {
        $status = new SphinxStatus(array(
            array('avg_query_readkb', 'OFF')
        ));

        $this->assertFalse($status->getAverageQueryReadKb());
    }

    /**
     * @test
     */
    public function shouldReturnAverageQueryReadTime()
    {
        $status = new SphinxStatus(array(
            array('avg_query_readtime', '5')
        ));

        $this->assertInternalType('float', $status->getAverageQueryReadTime());
        $this->assertEquals(5, $status->getAverageQueryReadTime());
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfAverageQueryReadTimeNotNumeric()
    {
        $status = new SphinxStatus(array(
            array('avg_query_readtime', 'OFF')
        ));

        $this->assertFalse($status->getAverageQueryReadTime());
    }
}
