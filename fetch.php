<?php

declare(strict_types = 1);

require_once 'src/autoload.php';

$main = new Main();
$main->run($argv[1], $argv[2]);