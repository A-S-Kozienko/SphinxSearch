<?php
namespace ASK\SphinxSearch;

use ASK\SphinxSearch\Exception\SphinxApiErrorException;
use ASK\SphinxSearch\Exception\SphinxApiWarningException;

class SphinxManager
{
    /**
     * @var \SphinxClient
     */
    protected $api;

    /**
     * array(
            'Alias1' => 'Index1',
     *      'Alias2' => 'Index2',
     * )
     *
     * @var array
     */
    protected $aliasToIndexMap;

    /**
     * @param \SphinxClient $api
     * @param array $aliasToIndexMap
     */
    public function __construct(\SphinxClient $api, array $aliasToIndexMap = array())
    {
        $this->api             = $api;
        $this->aliasToIndexMap = $aliasToIndexMap;
    }

    /**
     * @param array $indexes
     * @return SphinxRequest
     */
    public function createRequest(array $indexes)
    {
        return new SphinxRequest($this, $indexes);
    }

    /**
     * @param array $indexes
     * @return SphinxUpdateAttributesRequest
     */
    public function createUpdateAttributesRequest(array $indexes)
    {
        return new SphinxUpdateAttributesRequest($this, $indexes);
    }

    /**
     * @param SphinxRequest $request
     * @return SphinxResult
     */
    public function executeSingleRequest(SphinxRequest $request)
    {
        $this->addRequest($request);
        return $this->runQueries()[0];
    }

    /**
     * @param SphinxRequest[] $requests
     * @return SphinxResult[]
     */
    public function executeMultiRequests(array $requests)
    {
        foreach ($requests as $request) {
            $this->addRequest($request);
        }

        return $this->runQueries();
    }

    /**
     * @param SphinxUpdateAttributeRequest[]|SphinxUpdateAttributeRequest $requests
     * @param bool $flush
     * @throws Exception\SphinxApiErrorException
     * @throws \InvalidArgumentException
     */
    public function executeUpdateAttributeRequests($requests, $flush = false)
    {
        if (false == is_array($requests)) {
            $requests = array($requests);
        }

        foreach ($requests as $request) {
            if (false == ($request instanceof SphinxUpdateAttributeRequest)) {
                throw new \InvalidArgumentException('Type of "SphinxUpdateAttributeRequest" was expected.');
            }

            $this->api->UpdateAttributes(
                $this->resolveIndexes($request->getIndexes()),
                array($request->getAttribute()),
                $request->getValues(),
                $request->isMva()
            );

            $this->throwExceptionOnApiError();
            $this->throwExceptionOnApiWarning();
        }

        if ($flush) {
            $this->api->FlushAttributes();

            $this->throwExceptionOnApiError();
            $this->throwExceptionOnApiWarning();
        }
    }

    /**
     * @param string $alias
     * @return string
     * @throws \OutOfBoundsException
     */
    public function getIndexByAlias($alias)
    {
        if (false == $this->hasAlias($alias)) {
            throw new \OutOfBoundsException(sprintf('Index alias "%s" does not exists.', $alias));
        }

        return $this->aliasToIndexMap[$alias];
    }

    /**
     * @param $alias
     * @return bool
     */
    public function hasAlias($alias)
    {
        return isset($this->aliasToIndexMap[$alias]);
    }

    public function getStatus()
    {
        $status = $this->api->Status();

        $this->throwExceptionOnApiError();
        $this->throwExceptionOnApiWarning();

        return new SphinxStatus($status);
    }

    /**
     * @throws Exception\SphinxApiErrorException
     */
    protected function throwExceptionOnApiError()
    {
        $errorMessage = $this->api->GetLastError();
        if (false == empty($errorMessage)) {
            throw new SphinxApiErrorException($errorMessage);
        }
    }

    /**
     * @throws Exception\SphinxApiWarningException
     */
    protected function throwExceptionOnApiWarning()
    {
        $warningMessage = $this->api->GetLastWarning();
        if (false == empty($warningMessage)) {
            throw new SphinxApiWarningException($warningMessage);
        }
    }

    /**
     * @return SphinxResult[]
     * @throws Exception\SphinxApiWarningException
     * @throws Exception\SphinxApiErrorException
     */
    protected  function runQueries()
    {
        $results = $this->api->RunQueries();
        $this->api->_reqs = array(); // just in case it failed too early

        $this->throwExceptionOnApiError();
        $this->throwExceptionOnApiWarning();

        $sphinxResults = array();
        foreach ($results as $result) {
            $sphinxResults[] = new SphinxResult($result);
        }

        return $sphinxResults;
    }

    /**
     * @param SphinxRequest $request
     */
    protected function addRequest(SphinxRequest $request)
    {
        $this->api->ResetFilters();
        $this->api->ResetGroupBy();
        $this->api->ResetOverrides();

        $limits = $request->getLimits();
        $this->api->SetLimits($limits['offset'], $limits['limit'], $limits['maxMatches'], $limits['cutOff']);

        $this->api->SetMatchMode($request->getMatchMode());

        foreach ($request->getFilters() as $filter) {
            $this->api->SetFilter($filter['attribute'], $filter['values'], $filter['exclude']);
        }

        foreach ($request->getRangeFilters() as $filter) {
            $this->api->SetFilterRange($filter['attribute'], $filter['min'], $filter['max'], $filter['exclude']);
        }

        foreach ($request->getFloatRangeFilters() as $filter) {
            $this->api->SetFilterFloatRange($filter['attribute'], $filter['min'], $filter['max'], $filter['exclude']);
        }

        if ($groupBy = $request->getGroupBy()) {
            $this->api->SetGroupBy($groupBy['attribute'], $groupBy['func'], $groupBy['groupsort']);
        }

        if ($sortMode = $request->getSortMode()) {
            $this->api->SetSortMode($sortMode['mode'], $sortMode['sortBy']);
        }

        $this->api->SetGroupDistinct($request->getGroupDistinct());

        $this->api->AddQuery(
            $this->parametrizeQuery(trim(implode(' ', $request->getQueries())), $request->getQueryParameters()),
            implode(' ', $this->resolveIndexes($request->getIndexes())),
            $request->getComment()
        );
    }

    /**
     * @param string[] $indexes
     * @return string[]
     */
    public function resolveIndexes(array $indexes)
    {
        $realIndexes = array();

        foreach ($indexes as $index) {
            $realIndexes[] = $this->hasAlias($index) ? $this->getIndexByAlias($index) : $index;
        }

        return $realIndexes;
    }

    /**
     * @param string $query
     * @param array $parameters
     * @return string
     */
    protected function parametrizeQuery($query, array $parameters)
    {
        if (empty($query)) {
            return '';
        }

        if ($parameters) {
            $keys = array_map(function($key) {
                return ':' . $key;
            }, array_keys($parameters));

            $values = array_map(function($value) {
                return $this->api->EscapeString($value);
            }, array_values($parameters));

            $query = str_replace($keys, $values, $query);
        }

        return $query;
    }
}