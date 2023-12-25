<?php

function findIndicesForSum($numbers, $target) {
    $left = 0;
    $right = count($numbers) - 1;

    while ($left < $right) {
        $currentSum = $numbers[$left] + $numbers[$right];

        if ($currentSum === $target) {
          
            return [$left + 1, $right + 1];
        } elseif ($currentSum < $target) {
            $left++;
        } else {
            $right--;
        }
    }

   
    return null;
}


$numbers = [2, 7, 11, 15];
$target = 9;

$result = findIndicesForSum($numbers, $target);

if ($result !== null) {
    echo "Indices: [{$result[0]}, {$result[1]}] add up to the target.\n";
} else {
    echo "No such indices found.\n";
}







