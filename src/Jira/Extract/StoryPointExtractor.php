<?php

declare(strict_types = 1);

namespace Jira\Extract;

class StoryPointExtractor
{
    public function getStoryPoints(array $issueFields): ?float
    {
        if (array_key_exists('customfield_10016', $issueFields) === false) {
            return null;
        }

        return (float) $issueFields['customfield_10016'];
    }
}