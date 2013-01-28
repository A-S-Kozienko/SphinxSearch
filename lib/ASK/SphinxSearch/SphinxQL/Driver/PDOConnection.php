<?php
namespace ASK\SphinxSearch\SphinxQL\Driver;

class PDOConnection implements ConnectionInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @param string $host
     * @param int $port
     */
    public function __construct($host = '127.0.0.1', $port = 9306)
    {
        $this->pdo = new \PDO(sprintf('mysql:host=%s;port=%s;', $host, $port));
    }

    /**
     * @param sting $statement
     * @return array
     * @throws Exception\DriverException
     */
    public function query($statement)
    {
        if (false == $pdoStatement = $this->pdo->query($statement)) {
            throw new Exception\DriverException($this->pdo->errorInfo()[2]);
        }

        return $pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
    }
}