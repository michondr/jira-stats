<?php

declare(strict_types = 1);

namespace Jira\Extract;

class SprintNameExtractor
{
    public function getSprintName(array $issueFields): ?string
    {
        if (array_key_exists('customfield_10020', $issueFields) === false) {
            return null;
        }

        if ($issueFields['customfield_10020'] === null) {
            return null;
        }

        if (count($issueFields['customfield_10020']) === 0) {
            return null;
        }

        $lastSprintIndex = array_key_last($issueFields['customfield_10020']);

        if (array_key_exists('name', $issueFields['customfield_10020'][$lastSprintIndex]) === false) {
            return null;
        }

        return $issueFields['customfield_10020'][$lastSprintIndex]['name'];
    }
}