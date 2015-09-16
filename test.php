<?php

namespace spaceboy;

require_once ('base20.php');

foreach ([0, 1, 2, 10, 20, 399, 400, 7999, 8000, 159999, 160000] as $n) {
    try {
        $r = strToUpper(Base20::encode($n));
        echo "{$n}: {$r}\n";
    } catch (\Exception $ex) {
        echo "{$n}: Error {$ex->getMessage()}\n";
    }
}
echo "\n";
foreach (['FYMAB', 'FUMAC', 'FEMAK', 'FYMAV', 'FYHAB', 'FONAJ', 'MYMAB', 'TONAJ', 'TUNAJ', 'FIMAB', 'LIMAS'] as $n) {
    try {
        $r = strToUpper(Base20::decode($n));
        echo "{$n}: {$r}\n";
    } catch (\Exception $ex) {
        echo "{$n}: Error {$ex->getMessage()}\n";
    }
}
echo "\n";

