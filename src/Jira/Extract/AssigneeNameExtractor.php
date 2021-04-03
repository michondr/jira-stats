<?php

declare(strict_types = 1);

namespace Jira\Extract;

class AssigneeNameExtractor
{
    public function getAssigneeName(array $issueFields): ?string
    {
        if (array_key_exists('assignee', $issueFields) === false) {
            return null;
        }

        if ($issueFields['assignee'] === null) {
            return null;
        }

        if (array_key_exists('displayName', $issueFields['assignee']) === false) {
            return null;
        }

        return $issueFields['assignee']['displayName'];
    }
}