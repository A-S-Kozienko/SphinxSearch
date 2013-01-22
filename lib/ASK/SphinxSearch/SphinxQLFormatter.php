<?php
namespace ASK\SphinxSearch;

use ASK\SphinxSearch\SphinxQuery;

class SphinxQLFormatter
{
    public function format(SphinxQuery $query)
    {
        $ql[] = $this->formatSelect($query);
        $ql[] = $this->formatFrom($query);
        $ql[] = $this->formatWhere($query);

        if ($groupBy = $this->formatGroupBy($query)) {
            $ql[] = $groupBy;
        }

        if ($orderBy = $this->formatOrderBy($query)) {
            $ql[] = $orderBy;
        }

        $ql[] = $this->formatLimit($query);

        return implode(' ', $ql);
    }

    public function formatFrom(SphinxQuery $query)
    {
        return 'FROM ' . implode(', ', $query->getIndexes());
    }

    public function formatLimit(SphinxQuery $query)
    {
        $limits = $query->getLimits();
        return 'LIMIT ' . $limits['offset'] . ', ' . $limits['limit'];
    }

    public function formatFilters(SphinxQuery $query)
    {
        $filters = $query->getFilters();
        $ql = array();

        foreach ($filters as $filter) {
            $chunks = array($filter['attribute']);

            if (count($filter['values']) > 1) {
                $chunks[] = $filter['exclude'] ? 'NOT IN' : 'IN';
                $chunks[] = '(' . implode(',', $filter['values']) . ')';
            } else {
                $chunks[] = $filter['exclude'] ? '!=' : '=';
                $chunks[] = $filter['values'][0];
            }

            $ql[] = implode(' ', $chunks);
        }

        return implode(' AND ', $ql);
    }

    public function formatRangeFilters(SphinxQuery $query)
    {
        return $this->formatRange($query->getRangeFilters());
    }

    public function formatFloatRangeFilters(SphinxQuery $query)
    {
        return $this->formatRange($query->getFloatRangeFilters());
    }

    public function formatMatch(SphinxQuery $query)
    {
        return $query->getMatches() ? 'MATCH(\'' . implode(' ', $query->getMatches()) . '\')' : '';
    }

    public function formatOrderBy(SphinxQuery $query)
    {
        if ($sort = $query->getSortMode()) {
            return 'ORDER BY ' . $sort['sortBy'];
        }

        return '';
    }

    protected function formatRange(array $filters)
    {
        $ql = array();

        foreach ($filters as $filter) {
            $chunks = array($filter['attribute']);
            $chunks[] = ($filter['exclude'] ? 'NOT BETWEEN' : 'BETWEEN');
            $chunks[] = $filter['min'] . ' AND ' . $filter['max'];

            $ql[] = implode(' ', $chunks);
        }

        return implode(' AND ', $ql);
    }

    public function formatWhere(SphinxQuery $query)
    {
        $ql = array();

        if ($match = $this->formatMatch($query)) {
            $ql[] = $match;
        }

        if ($filters = $this->formatFilters($query)) {
            $ql[] = $filters;
        }

        if ($filters = $this->formatRangeFilters($query)) {
            $ql[] = $filters;
        }

        if ($filters = $this->formatFloatRangeFilters($query)) {
            $ql[] = $filters;
        }

        return $ql ? 'WHERE ' . implode(' AND ', $ql) : '';
    }

    public function formatGroupBy(SphinxQuery $query)
    {
        if ($groupBy = $query->getGroupBy()) {
            return 'GROUP BY ' . $groupBy['attribute'] . ' WITHIN GROUP ORDER BY ' . $groupBy['groupsort'];
        }

        return '';
    }

    public function formatGroupDistinct(SphinxQuery $query)
    {
        if ($groupDistinct = $query->getGroupDistinct()) {
            return 'COUNT(DISTINCT ' . $groupDistinct . ') AS @distinct';
        }

        return '';
    }

    public function formatSelect(SphinxQuery $query)
    {
        $selects = $query->getSelects();

        if ($query->getGroupBy() && $query->getGroupDistinct()) {
            $selects[] = $this->formatGroupDistinct($query);
        }

        return 'SELECT ' . ($selects ? trim(implode(', ', $selects)) : '*');
    }
}
