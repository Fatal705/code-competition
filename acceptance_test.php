#!/usr/bin/env php
<?php

include __DIR__ .'/vendor/autoload.php';

function doTest($offset, $total, $rowsPerPage, $maxNavigatorSize)
{

//----------------------------------------------------------------------------------------------------------------------
// Invoke your page enumerator here
//----------------------------------------------------------------------------------------------------------------------

    $nav = new Navigator($rowsPerPage, $maxNavigatorSize);
    return strval($nav->accept(array('total_rows' => $total, 'offset' => $offset)));
}

assert_options(ASSERT_BAIL, 1);
assert_options(ASSERT_CALLBACK, function () { echo "\nFailed\n\n"; exit (1); });

foreach (array(
    array('[1]', 0, 0),
    array('[1]', 0, 10),
    array('[1] 2', 0, 20),
    array('[1] 2 3', 0, 30),
    array('[1] 2 3 4', 0, 40),
    array('[1] 2 3 4 5', 0, 50),
    array('[1] 2 3 4 5', 0, 60),
    array('[1] 2 3 4 5', 0, 70),
    array('[1] 2 3 4 5', 9, 70),
    array('1 [2] 3 4 5', 10, 70),
    array('1 2 [3] 4 5', 20, 70),
    array('2 3 [4] 5 6', 30, 70),
    array('3 4 [5] 6 7', 40, 70),
    array('3 4 5 [6] 7', 50, 70),
    array('3 4 5 6 [7]', 60, 70),
    array('3 4 5 6 [7]', 69, 70),

    array('[1]', 0, 19, 20),
    array('1 [2]', 25, 26, 25),
    array('9 10 [11] 12 13', 250, 500, 25),
    array('16 17 18 19 [20]', 499, 500, 25),
    array('6 7 8 [9] 10 11 12', 200, 500, 25, 7),
    array('14 15 16 17 18 19 [20]', 499, 500, 25, 7)
) as $case) {

    list($expected, $offset, $total, $rowsPerPage, $pagesCount) = array_merge($case, array(null, null));

    $actual = doTest($offset, $total, $rowsPerPage ?: 10, $pagesCount ?: 5);

    echo 'Expected: ' . $expected . ' Actual: ' . $actual . "\n";
    assert($expected === $actual);
}

echo "\nOk\n\n";
