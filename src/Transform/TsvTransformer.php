<?php

declare(strict_types = 1);

namespace Transform;

use Jira\JiraIssue;

class TsvTransformer
{
    private const UNDEFINED_SPRINT = 'undefined_sprint';
    private const UNDEFINED_ASSIGNEE = 'undefined_assignee';
    private const UNDEFINED_REVIEWER = 'undefined_reviewer';

    /**
     * @param JiraIssue[] $issues
     * @return array
     */
    public function transform(array $issues): array
    {
        $sprintPerformanceRows[] = [
            'sprintName',
            'issue',
            'assignee',
            'reviewer',
            'story_points',
        ];

        foreach ($issues as $issue) {
            $sprint = $issue->hasSprintKey() ? $issue->getSprintKey() : self::UNDEFINED_SPRINT;
            $storyPoints = $issue->hasStoryPoints() ? $issue->getStoryPoints() : 0;
            $assignee = $issue->hasAssignee() ? $issue->getAssignee() : self::UNDEFINED_ASSIGNEE;
            $reviewer = $issue->hasReviewer() ? $issue->getReviewer() : self::UNDEFINED_REVIEWER;

            $sprintPerformanceRows[] = [
                $sprint,
                $issue->getId(),
                $assignee,
                $reviewer,
                $storyPoints,
            ];
        }

        usort(
            $sprintPerformanceRows,
            function ($valA, $valB) {
                $sprintA = $valA[0];
                $sprintB = $valB[0];
                $aDoesMatch = preg_match_all('~\d+~', $sprintA, $matchesA);
                $bDoesMatch = preg_match_all('~\d+~', $sprintB, $matchesB);

                if ($aDoesMatch === 0 || $bDoesMatch === 0) {
                    return $aDoesMatch <=> $bDoesMatch;
                }

                return $matchesA[0][0] <=> $matchesB[0][0];
            }
        );

        return $sprintPerformanceRows;
    }
}