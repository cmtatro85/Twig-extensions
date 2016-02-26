<?php

/**
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Ricard Clau <ricard.clau@gmail.com>
 */
class Twig_Extensions_Extension_Array extends Twig_Extension
{
    /**
     * Returns a list of filters.
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = array(
             new Twig_SimpleFilter('shuffle', 'twig_shuffle_filter'),
             new Twig_SimpleFilter('column_sum', 'twig_column_sum_filter'),
        );

        return $filters;
    }
    /**
     * Name of this extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'array';
    }
}

/**
 * Shuffles an array.
 *
 * @param array|Traversable $array An array
 *
 * @return array
 */
function twig_shuffle_filter($array)
{
    if ($array instanceof Traversable) {
        $array = iterator_to_array($array, false);
    }

    shuffle($array);

    return $array;
}

/**
 * Sums a column an array.
 *
 * @param array|Traversable $array An array or arrays
 * @param string $column key from each array you wish to sum
 *
 * @return integer
 */
function twig_column_sum_filter($array, $column)
{
    if ($array instanceof Traversable) {
        $array = iterator_to_array($array, false);
    }

    if (function_exists('array_column')) {
        $columnsArray = array_column($aray, $column);
    } else {
        $columnsArray = [];
        foreach ($array as $subArray) {
            if (isset($subArray[$column])) {
                $columnsArray[] = $subArray[$column];
            }
        };
    }

    return array_sum($columnsArray);
}
