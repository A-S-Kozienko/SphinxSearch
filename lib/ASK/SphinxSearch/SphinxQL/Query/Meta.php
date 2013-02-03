<?php
namespace ASK\SphinxSearch\SphinxQL\Query;

/**
 * Meta
 */
class Meta
{
    /**
     * @var int $total
     */
    protected $total;

    /**
     * @var int $totalFound
     */
    protected $totalFound;

    /**
     * @var float $executionTime
     */
    protected $executionTime;

    /**
     * @var array
     */
    protected $keywords;

    /**
     * @param array $data
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $data)
    {
        if (count($data) < 3) {
            throw new \InvalidArgumentException();
        }

        $this->parseData($data);
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getTotalFound()
    {
        return $this->totalFound;
    }

    /**
     * @return float
     */
    public function getExecutionTime()
    {
        return $this->executionTime;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param array &$data
     */
    protected function parseData(array &$data)
    {
        $this->total            = (int) $data[0]['Value'];
        $this->totalFound       = (int) $data[1]['Value'];
        $this->executionTime    = (float) $data[2]['Value'];

        $this->keywords = array();
        for ($i = 3; $i < count($data); $i += 3) {
            $this->keywords[]   = array(
                'keyword'       => $data[$i]['Value'],
                'docs'          => (int) $data[$i + 1]['Value'],
                'hits'          => (int) $data[$i + 2]['Value'],
            );
        }
    }
}