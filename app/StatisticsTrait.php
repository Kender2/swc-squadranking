<?php

namespace App;


trait StatisticsTrait
{
    /**
     * @param array $values
     * @return array
     */
    protected static function getTotalsForStats(array $values)
    {
        $factionCount = max(1, count($values));
        $stats = array_keys(current($values));

        $totals = [];
        foreach ($stats as $stat) {
            $totals[$stat] = 0;
            foreach ($values as $data) {
                $totals[$stat] += $data[$stat];
            }
            if (strpos($stat, 'Avg') === 0) {
                $totals[$stat] /= $factionCount;
            }
        }
        return $totals;
    }

    /**
     * @param array $factions
     * @param array $columns
     * @return array
     */
    protected static function getStatsForFactions(array $factions, array $columns)
    {
        $terms = [];
        foreach ($columns as $title => $expression) {
            $terms[] = $expression . ' AS "' . $title . '"';
        }
        $query = implode(',', $terms);

        $values = [];
        foreach ($factions as $faction) {
            $values[ucfirst($faction)] = get_object_vars(self::whereFaction($faction)
                ->getQuery()
                ->selectRaw($query)
                ->first());
        }
        return $values;
    }
}
