<?php

namespace App\Helper;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class PaginationHelper.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class PaginationHelper
{
    public static function portalPaginationQueryBuilder(QueryBuilder $qb, $options)
    {
        if (!isset($options->itemsPerPage) || !isset($options->page))
        {
            throw new \InvalidArgumentException('No itemsPerPage or page option found.');
        }
        $limit = $options->itemsPerPage;
        $page = $options->page;

        $qb->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        // order by
        if (isset($options->sortBy) && count($options->sortBy) > 0)
        {
            $alias = $qb->getRootAliases();
            for ($x = 0; $x <= (count($options->sortBy) - 1); ++$x)
            {
                $filter = $options->sortBy[$x];
                $order = ($options->sortDesc[$x] ? 'DESC' : 'ASC');

                // if $filter doens't have dot, add 'q.'
                if (!strpos($filter, '.'))
                {
                    $filter = sprintf('%s.%s', $alias[0], $filter);
                }

                $qb->addOrderBy($filter, $order);
            }
        }

        self::searchQuery($qb, $options);

        return new Paginator($qb, $fetchJoinCollection = true);
    }

    public static function portalPaginationCountQueryBuilder(QueryBuilder $qb, $options)
    {
        return self::searchQuery($qb, $options)
            ->getQuery()
            ->getSingleScalarResult();
    }

    private static function searchQuery(QueryBuilder $qb, $options)
    {
        if (
            (isset($options->query) && strlen($options->query) > 0)
            && isset($options->fields)
        ) {
            $query = [];
            $alias = $qb->getRootAliases();
            foreach ($options->fields as $field)
            {
                if (!isset($field->search) || !$field->search)
                {
                    continue;
                }

                $value = $field->value;
                // if $filter doens't have dot, add 'q.'
                if (!strpos($value, '.'))
                {
                    $value = sprintf('%s.%s', $alias[0], $value);
                }

                $query[] = sprintf("%s LIKE '%%%s%%'", $value, $options->query);
            }

            $qb->andWhere(implode(' OR ', $query));
        }

        return $qb;
    }
}
