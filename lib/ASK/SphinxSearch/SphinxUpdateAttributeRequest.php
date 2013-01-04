<?php
namespace ASK\SphinxSearch;

class SphinxUpdateAttributeRequest
{
    /**
     * @var SphinxManager
     */
    private $manager;

    /**
     * @var array
     */
    private $indexes;

    /**
     * @var string
     */
    private $attribute;

    /**
     * @var bool
     */
    private $mva;

    /**
     * @var array
     */
    private $values = array();

    /**
     * @param SphinxManager $manager
     * @param array $indexes
     * @param string $attribute
     * @param bool $mva
     */
    public function __construct(SphinxManager $manager, array $indexes, $attribute, $mva = false)
    {
        $this->manager      = $manager;
        $this->indexes      = $indexes;
        $this->attribute    = $attribute;
        $this->mva          = $mva;
    }

    /**
     * @param bool $flush - forces searchd to flush pending attribute updates to disk
     * @see http://sphinxsearch.com/docs/current.html#api-func-flushattributes
     */
    public function execute($flush = false)
    {
        return $this->manager->executeUpdateAttributeRequests($this, $flush);
    }

    /**
     * @return array
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

    /**
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @return bool
     */
    public function isMva()
    {
        return $this->mva;
    }

    /**
     * @param int $id
     * @param int[]|int $value
     * @return SphinxUpdateAttributeRequest
     */
    public function addValue($id, $value)
    {
        $this->values[$id] = array($value);

        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }
}
