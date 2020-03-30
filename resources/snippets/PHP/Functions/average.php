<?php

// Returns the average of two or more numbers.
// Use array_sum() for all the values in $items and return the result divided by their count().

function average(...$items)
{
    $count = count($items);

    return $count === 0 ? 0 : array_sum($items) / $count;
}

average(1, 2, 3); // 2
