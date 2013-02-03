<?php
namespace ASK\SphinxSearch\SphinxQL\Driver;

use ASK\SphinxSearch\SphinxQL\Exception\SphinxErrorException;

/**
 * PDOConnection
 */
class PDOConnection implements ConnectionInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @param string $host
     * @param int    $port
     */
    public function __construct($host = '127.0.0.1', $port = 9306)
    {
        $this->pdo = new \PDO(sprintf('mysql:host=%s;port=%s;', $host, $port));
    }

    /**
     * {@inheritDoc}
     */
    public function query($statement)
    {
        if (false == $pdoStatement = $this->pdo->query($statement)) {
            $errorInfo = $this->pdo->errorInfo();
            throw new SphinxErrorException($errorInfo[2], $errorInfo[1]);
        }

        return $pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
    }
}