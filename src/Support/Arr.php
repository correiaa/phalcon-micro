<?php

namespace Nilnice\Phalcon\Support;

class Arr
{
    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param  array $array
     * @param  int   $depth
     *
     * @return array
     */
    public static function flatten(array $array, $depth = INF) : array
    {
        $result = [];
        foreach ($array as $item) {
            if (! \is_array($item)) {
                $result[] = $item;
            } elseif ($depth === 1) {
                $result = array_merge($result, array_values($item));
            } else {
                $result = array_merge(
                    $result,
                    static::flatten($item, $depth - 1)
                );
            }
        }

        return $result;
    }
}
