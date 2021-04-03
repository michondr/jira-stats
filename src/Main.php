<?php

declare(strict_types = 1);

use Api\JiraClient;
use Jira\JiraIssueSerializer;

class Main
{
    public const PAGINATOR_ITEMS_PER_PAGE = 100;

    private JiraClient $jiraClient;
    private JiraIssueSerializer $jiraIssueSerializer;

    public function __construct(
        JiraClient $jiraClient,
        JiraIssueSerializer $jiraIssueSerializer
    )
    {
        $this->jiraClient = $jiraClient;
        $this->jiraIssueSerializer = $jiraIssueSerializer;
    }

    public function run(string $jiraCompany, string $userEmail, string $apiToken)
    {
        var_dump($jiraCompany);
        var_dump($userEmail);
        var_dump($apiToken);

        $page = 0;
        $issues = $this->getJiraIssues($jiraCompany, $userEmail, $apiToken, $page);



        var_dump(json_encode($sprintPerformance));

    }

    private function getJiraIssues(string $jiraCompany, string $userEmail, string $apiToken, int $page): array
    {
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