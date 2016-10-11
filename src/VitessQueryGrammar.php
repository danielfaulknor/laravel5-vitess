<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 2016-08-03
 * Time: 12:40
 */

namespace Tjcelaya\Laravel5\Vitess;


use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\MySqlGrammar;

class VitessQueryGrammar extends MySqlGrammar
{
    /**
     * Compile the "limit" portions of the query.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  int                                $limit
     *
     * @return string
     */
    protected function compileLimit(Builder $query, $limit)
    {
        return 'limit ' . (int)$query->offset . ', ' . (int)$limit;
    }

    /**
     * Compile the "offset" portions of the query.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  int                                $offset
     *
     * @return string
     */
    protected function compileOffset(Builder $query, $offset)
    {
        return '';
    }

    /**
     * Compile an aggregated select clause. We need to add GROUP BY and ORDER BY clauses
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  array                              $aggregate
     *
     * @return string
     */
    protected function compileAggregate(Builder $query, $aggregate)
    {

        // If the query has a "distinct" constraint and we're not asking for all columns
        // we need to prepend "distinct" onto the column name so that the query takes
        // it into account when it performs the aggregating operations on the data.
        if ($query->distinct && $column !== '*') {
            $column = 'distinct ' . $column;
        }

        $selects = [];

        if (is_array($query->orders)) {
            foreach ($query->orders as $order) {
                $selects[] = $order['column'];
            }
        }

        if (is_array($query->groups)) {
            foreach ($query->groups as $group) {
                $selects[] = $group;
            }
        }

        $compiledSelect = 'select ' . $aggregate['function'] . '(' . $column . ') as aggregate';

        if (count($selects)) {
            $compiledSelect .= ', ' . $this->columnize($selects);
        }

        return $compiledSelect;
    }
}