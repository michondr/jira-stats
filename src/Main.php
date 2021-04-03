<?php

declare(strict_types = 1);

class Main
{

    public function __construct()
    {
    }

    public function run(string $userEmail, string $apiToken)
    {
        var_dump($userEmail);
        var_dump($apiToken);
    }
}