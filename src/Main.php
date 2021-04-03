<?php

declare(strict_types = 1);

use Api\JiraClient;
use Jira\JiraIssueSerializer;
use Transform\ListTransformer;
use Transform\TsvMatrixTransformer;
use Transform\TsvTransformer;

class Main
{
    public const PAGINATOR_ITEMS_PER_PAGE = 100;

    private JiraClient $jiraClient;
    private JiraIssueSerializer $jiraIssueSerializer;
    private ListTransformer $listTransformer;
    private TsvTransformer $tsvTransformer;
    private TsvMatrixTransformer $matrixTransformer;

    public function __construct(
        JiraClient $jiraClient,
        JiraIssueSerializer $jiraIssueSerializer,
        ListTransformer $listTransformer,
        TsvTransformer $tsvTransformer,
        TsvMatrixTransformer $matrixTransformer
    )
    {
        $this->jiraClient = $jiraClient;
        $this->jiraIssueSerializer = $jiraIssueSerializer;
        $this->listTransformer = $listTransformer;
        $this->tsvTransformer = $tsvTransformer;
        $this->matrixTransformer = $matrixTransformer;
    }

    public function run(string $jiraCompany, string $userEmail, string $apiToken, string $output)
    {
        $issues = $this->getJiraIssues($jiraCompany, $userEmail, $apiToken);

        if ($output === 'tsv') {
            $data = $this->tsvTransformer->transform($issues);
            foreach ($data as $dataRow) {
                echo implode("\t", $dataRow);
                echo "\n";
            }
        }

        if ($output === 'matrix') {
            $data = $this->matrixTransformer->transform($issues);

            $firstSetKey = array_key_first($data);

            echo 'sprint name' . "\t";
            foreach ($data[$firstSetKey] as $header => $value) {
                echo $header . "\t";
            }
            echo "\n";

            foreach ($data as $sprint => $dataRow) {
                echo $sprint . "\t";
                echo implode("\t", $dataRow);
                echo "\n";
            }
        }

        if ($output === 'list') {
            $data = $this->listTransformer->transform($issues);
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    }

    private function getJiraIssues(string $jiraCompany, string $userEmail, string $apiToken): array
    {
        $page = 0;
        $issues = [];

        while (true) {
            $data = $this->jiraClient->callApi(
                $jiraCompany,
                $userEmail,
                $apiToken,
                $page * self::PAGINATOR_ITEMS_PER_PAGE,
                self::PAGINATOR_ITEMS_PER_PAGE
            );

            $resultCount = $data['total'];

            foreach ($data['issues'] as $dataIssue) {
                $issues[] = $this->jiraIssueSerializer->deserialize($dataIssue);
            }

            $page++;

            if (count($issues) === $resultCount) {
                break;
            }
        }

        return $issues;
    }
}