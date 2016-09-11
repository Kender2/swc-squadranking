<?php

namespace App;


trait StatisticsTrait
{
    /**
     * @param array $values
     * @return array
     */
    protected static function addTotalsToStats(array &$values)
    {
        $factionCount = max(1, count($values));

        foreach ($values as $faction => $data) {
            foreach ($data as $stat => $value) {
                isset($values['All'][$stat]) ? $values['All'][$stat] += $value : $values['All'][$stat] = $value;
            }
        }

        if (!empty($values)) {
            foreach ($values['All'] as $stat => $value) {
                if (strpos($stat, 'Avg') === 0) {
                    $values['All'][$stat] /= $factionCount;
                }
            }
        }
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
