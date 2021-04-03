<?php

declare(strict_types = 1);

require_once 'src/autoload.php';

$main = new Main(
    new \Api\JiraClient(
        new \Api\ResponseDeserializer()
    ),
    new \Jira\JiraIssueSerializer(
        new \Jira\Extract\SprintNameExtractor(),
        new \Jira\Extract\AssigneeNameExtractor(),
        new \Jira\Extract\ReviewerNameExtractor(),
        new \Jira\Extract\StoryPointExtractor()
    ),
    new \Transform\ListTransformer(),
    new \Transform\TsvTransformer(),
    new \Transform\TsvMatrixTransformer()
);

$main->run($argv[1], $argv[2], $argv[3], $argv[4]);