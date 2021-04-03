<?php

declare(strict_types = 1);

include 'Main.php';

foreach (glob(__DIR__ . '/*/*.php') as $file) {
    include $file;
}
foreach (glob(__DIR__ . '/*/*/*.php') as $file) {
    include $file;
}
foreach (glob(__DIR__ . '/*/*/*/*.php') as $file) {
    include $file;
}

function dd($data)
{
    var_dump($data);
    die;
}
