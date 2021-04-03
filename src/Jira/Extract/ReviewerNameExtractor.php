<?php

declare(strict_types = 1);

namespace Jira\Extract;

class ReviewerNameExtractor
{
    public function getReviewerName(array $issueFields): ?string
    {
        if (array_key_exists('customfield_10029', $issueFields) === false) {
            return null;
        }

        if($issueFields['customfield_10029'] === null){
            return null;
        }

        if (count($issueFields['customfield_10029']) === 0) {
            return null;
        }

        if (array_key_exists('displayName', $issueFields['customfield_10029'][0]) === false) {
            return null;
        }

        return $issueFields['customfield_10029'][0]['displayName'];
    }
}