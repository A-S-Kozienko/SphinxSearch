<?php
namespace ASK\SphinxSearch\SphinxQL;

use ASK\SphinxSearch\SphinxQL\Driver\ConnectionInterface;
use ASK\SphinxSearch\SphinxQL\Logging\SphinxLogger;
use ASK\SphinxSearch\SphinxQL\Exception\SphinxWarningException;

/**
 * SphinxSearch
 */
class SphinxSearch
{
    /**
     * @var \ASK\SphinxSearch\SphinxQL\Driver\ConnectionInterface
     */
    protected $connection;

    /**
     * @var \ASK\SphinxSearch\SphinxQL\Logging\SphinxLogger
     */
    protected $logger;

    /**
     * @var string $ranker
     */
    protected $ranker;

    /**
     * @var int $ranker
     */
    protected $maxMatches;

    /**
     * @var int $cutoff
     */
    protected $cutoff;

    /**
     * @var int $maxQueryTime
     */
    protected $maxQueryTime;

    /**
     * @var int $retryCount
     */
    protected $retryCount;

    /**
     * @var int $retryDelay
     */
    protected $retryDelay;

    /**
     * @param \ASK\SphinxSearch\SphinxQL\Driver\ConnectionInterface $connection   connection
     * @param string                                                $ranker       any of 'proximity_bm25', 'bm25', 'none', 'wordcount', 'proximity', 'matchany', or 'fieldmask'
     * @param int                                                   $maxMatches   per-query max matches value
     * @param int                                                   $cutoff       max found matches threshold
     * @param int                                                   $maxQueryTime max search time threshold, msec
     * @param int                                                   $retryCount   distributed retries count
     * @param int                                                   $retryDelay   distributed retry delay, msec
     */
    public function __construct(ConnectionInterface $connection, $ranker = null, $maxMatches = null, $cutoff = null, $maxQueryTime = null, $retryCount = null, $retryDelay = null)
    {
        $this->connection   = $connection;
        $this->ranker       = $ranker;
        $this->maxMatches   = $maxMatches;
        $this->cutoff       = $cutoff;
        $this->maxQueryTime = $maxQueryTime;
        $this->retryCount   = $retryCount;
        $this->retryDelay   = $retryDelay;
    }

    /**
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        $qb = new QueryBuilder($this);

        if (null !== $this->ranker) {
            $qb->setRanker($this->ranker);
        }

        if (null !== $this->maxMatches) {
            $qb->setMaxMatches($this->maxMatches);
        }

        if (null !== $this->cutoff) {
            $qb->setCutoff($this->cutoff);
        }

        if (null !== $this->maxQueryTime) {
            $qb->setMaxQueryTime($this->maxQueryTime);
        }

        if (null !== $this->retryCount) {
            $qb->setRetryCount($this->retryCount);
        }

        if (null !== $this->retryDelay) {
            $qb->setRetryDelay($this->retryDelay);
        }

        return $qb;
    }

    /**
     * @param \ASK\SphinxSearch\SphinxQL\Logging\SphinxLogger $logger
     */
    public function setLogger(SphinxLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $query
     *
     * @return array
     *
     * @throws \ASK\SphinxSearch\SphinxQL\Exception\SphinxErrorException
     * @throws \ASK\SphinxSearch\SphinxQL\Exception\SphinxWarningException
     */
    public function query($query)
    {
        if ($this->logger) {
            $this->logger->startQuery($query);
        }

        $result = $this->connection->query($query);
        if ($warning = $this->showWarnings()) {
            throw new SphinxWarningException($warning[0]['Message'], $warning[0]['Code']);
        }

        if ($this->logger) {
            $this->logger->stopQuery($result);
        }

        return $result;
    }

    public function showStatus()
    {
        return $this->query('SHOW STATUS');
    }

    /**
     * @return array
     */
    protected function showWarnings()
    {
        return $this->connection->query('SHOW WARNINGS');
    }

    public function showMeta()
    {
        return $this->query('SHOW META');
    }
}