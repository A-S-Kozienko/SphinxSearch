<?php
namespace ASK\SphinxSearch;

class SphinxStatus
{
    /**
     * @var int
     */
    private $uptime;

    /**
     * @var int
     */
    private $connections;

    /**
     * @var int
     */
    private $maxedOut;

    /**
     * @var int;
     */
    private $commandSearch;

    /**
     * @var int
     */
    private $commandExcerpt;

    /**
     * @var int
     */
    private $commandUpdate;

    /**
     * @var int
     */
    private $commandKeywords;

    /**
     * @var int
     */
    private $commandPersist;

    /**
     * @var int
     */
    private $commandStatus;

    /**
     * @var int
     */
    private $commandFlushAttributes;

    /**
     * @var int
     */
    private $agentConnect;

    /**
     * @var int
     */
    private $agentRetry;

    /**
     * @var int
     */
    private $queries;

    /**
     * @var int
     */
    private $distQueries;

    /**
     * @var float
     */
    private $queryWall;

    /**
     * @var
     */
    private $queryCpu;

    /**
     * @var float
     */
    private $distWall;

    /**
     * @var float
     */
    private $distLocal;

    /**
     * @var float
     */
    private $distWait;

    /**
     * @var int
     */
    private $queryReads;

    /**
     * @var float
     */
    private $queryReadKb;

    /**
     * @var float
     */
    private $queryReadTime;

    /**
     * @var float
     */
    private $averageQueryWall;

    /**
     * @var float
     */
    private $averageQueryCpu;

    /**
     * @var float
     */
    private $averageDistWall;

    /**
     * @var float
     */
    private $averageDistLocal;

    /**
     * @var float
     */
    private $averageDistWait;

    /**
     * @var int
     */
    private $averageQueryReads;

    /**
     * @var float
     */
    private $averageQueryReadKb;

    /**
     * @var float
     */
    private $averageQueryReadTime;

    public function __construct(array $status)
    {
        $keysToAttributeMap = array(
            'uptime'                    => 'uptime',
            'connections'               => 'connections',
            'maxed_out'                 => 'maxedOut',
            'command_search'            => 'commandSearch',
            'command_excerpt'           => 'commandExcerpt',
            'command_update'            => 'commandUpdate',
            'command_keywords'          => 'commandKeywords',
            'command_persist'           => 'commandPersist',
            'command_status'            => 'commandStatus',
            'command_flushattrs'        => 'commandFlushAttributes',
            'agent_connect'             => 'agentConnect',
            'agent_retry'               => 'agentRetry',
            'queries'                   => 'queries',
            'dist_queries'              => 'distQueries',
            'query_wall'                => 'queryWall',
            'query_cpu'                 => 'queryCpu',
            'dist_wall'                 => 'distWall',
            'dist_local'                => 'distLocal',
            'dist_wait'                 => 'distWait',
            'query_reads'               => 'queryReads',
            'query_readkb'              => 'queryReadKb',
            'query_readtime'            => 'queryReadTime',
            'avg_query_wall'            => 'averageQueryWall',
            'avg_query_cpu'             => 'averageQueryCpu',
            'avg_dist_wall'             => 'averageDistWall',
            'avg_dist_local'            => 'averageDistLocal',
            'avg_dist_wait'             => 'averageDistWait',
            'avg_query_reads'           => 'averageQueryReads',
            'avg_query_readkb'          => 'averageQueryReadKb',
            'avg_query_readtime'        => 'averageQueryReadTime',
        );

        foreach ($status as $row) {
            if (isset($keysToAttributeMap[$row[0]])) {
                $this->$keysToAttributeMap[$row[0]] = is_numeric($row[1]) ? $row[1] : false;
            }
        }
    }

    /**
     * @return int
     */
    public function getUptime()
    {
        return (int) $this->uptime;
    }

    /**
     * @return int
     */
    public function getConnections()
    {
        return (int) $this->connections;
    }

    /**
     * @return int
     */
    public function getMaxedOut()
    {
        return (int) $this->maxedOut;
    }

    /**
     * @return int
     */
    public function getCommandSearch()
    {
        return (int) $this->commandSearch;
    }

    /**
     * @return int
     */
    public function getCommandExcerpt()
    {
        return (int) $this->commandExcerpt;
    }

    /**
     * @return int
     */
    public function getCommandUpdate()
    {
        return (int) $this->commandUpdate;
    }

    /**
     * @return int
     */
    public function getCommandKeywords()
    {
        return (int) $this->commandKeywords;
    }

    /**
     * @return int
     */
    public function getCommandPersist()
    {
        return (int) $this->commandPersist;
    }

    /**
     * @return int
     */
    public function getCommandStatus()
    {
        return (int) $this->commandStatus;
    }

    /**
     * @return int
     */
    public function getCommandFlushAttributes()
    {
        return (int) $this->commandFlushAttributes;
    }

    /**
     * @return int
     */
    public function getAgentConnect()
    {
        return (int) $this->agentConnect;
    }

    /**
     * @return int
     */
    public function getAgentRetry()
    {
        return (int) $this->agentRetry;
    }

    /**
     * @return int
     */
    public function getQueries()
    {
        return (int) $this->queries;
    }

    /**
     * @return int
     */
    public function getDistQueries()
    {
        return (int) $this->distQueries;
    }

    /**
     * @return float
     */
    public function getQueryWall()
    {
        return (float) $this->queryWall;
    }

    /**
     * @return bool|float
     */
    public function getQueryCpu()
    {
        return (false === $this->queryCpu) ? false : (float) $this->queryCpu;
    }

    /**
     * @return float
     */
    public function getDistWall()
    {
        return (float) $this->distWall;
    }

    /**
     * @return float
     */
    public function getDistLocal()
    {
        return (float) $this->distLocal;
    }

    /**
     * @return float
     */
    public function getDistWait()
    {
        return (float) $this->distWait;
    }

    /**
     * @return bool|float
     */
    public function getQueryReads()
    {
        return (false === $this->queryReads) ? false : (float) $this->queryReads;
    }

    /**
     * @return bool|float
     */
    public function getQueryReadKb()
    {
        return (false === $this->queryReadKb) ? false : (float) $this->queryReadKb;
    }

    /**
     * @return bool|float
     */
    public function getQueryReadTime()
    {
        return (false === $this->queryReadTime) ? false : (float) $this->queryReadTime;
    }

    /**
     * @return float
     */
    public function getAverageQueryWall()
    {
        return (float) $this->averageQueryWall;
    }

    /**
     * @return bool|float
     */
    public function getAverageQueryCpu()
    {
        return (false === $this->averageQueryCpu) ? false : (float) $this->averageQueryCpu;
    }

    /**
     * @return float
     */
    public function getAverageDistWall()
    {
        return (float) $this->averageDistWall;
    }

    /**
     * @return float
     */
    public function getAverageDistLocal()
    {
        return (float) $this->averageDistLocal;
    }

    /**
     * @return float
     */
    public function getAverageDistWait()
    {
        return (float) $this->averageDistWait;
    }

    /**
     * @return bool|float
     */
    public function getAverageQueryReads()
    {
        return (false === $this->averageQueryReads) ? false : (float) $this->averageQueryReads;
    }

    /**
     * @return bool|float
     */
    public function getAverageQueryReadKb()
    {
        return (false === $this->averageQueryReadKb) ? false : (float) $this->averageQueryReadKb;
    }

    /**
     * @return bool|float
     */
    public function getAverageQueryReadTime()
    {
        return (false === $this->averageQueryReadTime) ? false : (float) $this->averageQueryReadTime;
    }
}