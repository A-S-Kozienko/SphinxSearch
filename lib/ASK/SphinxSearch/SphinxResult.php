<?php
namespace ASK\SphinxSearch;

class SphinxResult
{
    /**
     * @var array
     */
    protected $result;

    /**
     * @param array $result
     */
    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * Hash which maps found document IDs to another small hash containing
     * document weight and attribute values (or an array of the similar small
     * hashes if SetArrayResult() was enabled).
     *
     *
     */
    public function getMatches()
    {
        return isset($this->result['matches']) ? $this->result['matches'] : array();
    }

    /**
     * Total amount of matches retrieved on server
     * (ie. to the server side result set) by this query.
     * You can retrieve up to this amount of matches from server
     * for this query text with current query settings.
     *
     * @return integer
     */
    public function getTotal()
    {
        return isset($this->result['total']) ? (integer) $this->result['total'] : 0;
    }

    /**
     * Total amount of matching documents in index
     * (that were found and processed on server).
     *
     * @return integer
     */
    public function getTotalFound()
    {
        return isset($this->result['total_found']) ? (integer) $this->result['total_found'] : 0;
    }

    /**
     * Query error message reported by searchd
     * (string, human readable). Empty if there were no errors.
     *
     * @return string
     */
    public function getError()
    {
        return isset($this->result['error']) ? $this->result['error'] : '';
    }

    /**
     * @return boolean
     */
    public function hasError()
    {
        $error = $this->getError();
        return false == empty($error);
    }

    /**
     * Query warning message reported by searchd
     * (string, human readable). Empty if there were no warnings.
     *
     * @return string
     */
    public function getWarning()
    {
        return isset($this->result['warning']) ? $this->result['warning'] : '';
    }

    /**
     * @return boolean
     */
    public function hasWarning()
    {
        $warning = $this->getWarning();
        return false == empty($warning);
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return isset($this->result['status']) ? (integer) $this->result['status'] : 0;
    }

    /**
     * @return float|null
     */
    public function getExecutionTime()
    {
        return isset($this->result['time']) ? (float) $this->result['time'] : null;
    }

    /**
     * Hash which maps query keywords (case-folded, stemmed, and otherwise processed)
     * to a small hash with per-keyword statitics ("docs", "hits").
     *
     * array(
     *     'word1' => array (
     *         'docs' => '30'
     *         'hits' => '30'
     *     )
     *     'word2' => array (
     *         'docs' => '0'
     *         'hits' => '0'
     *     )
     * )
     *
     * @return array
     */
    public function getWords()
    {
        return isset($this->result['words']) ? $this->result['words'] : array();
    }
}