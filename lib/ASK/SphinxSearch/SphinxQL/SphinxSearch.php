<?php
namespace ASK\SphinxSearch\SphinxQL;

use ASK\SphinxSearch\SphinxQL\Driver\ConnectionInterface;
use ASK\SphinxSearch\SphinxQL\Logging\SphinxLogger;
use ASK\SphinxSearch\SphinxQL\Exception\SphinxWarningException;
use ASK\SphinxSearch\SphinxQL\Query\QueryBuilder;
use ASK\SphinxSearch\SphinxQL\Query\Meta;

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
            throw new SphinxWarningException($warning['message'], $warning['code']);
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
     * @return \ASK\SphinxSearch\SphinxQL\Query\Meta
     */
    public function showMeta()
    {
        return new Meta($this->query('SHOW META'));
    }

    /**
     * @return array|null
     */
    public function showWarnings()
    {
        if ($warning = $this->connection->query('SHOW WARNINGS')) {
            return array(
                'message' => $warning[0]['Message'],
                'code'    => $warning[0]['Code'],
            );
        }

        return null;
    }

    /**
     * @return void
     */
    public function startTransaction()
    {
        $this->query('START TRANSACTION');
    }

    /**
     * @return void
     */
    public function commit()
    {
        $this->query('COMMIT');
    }

    /**
     * @return void
     */
    public function rollback()
    {
        $this->query('ROLLBACK');
    }
}