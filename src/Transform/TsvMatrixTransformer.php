<?php

declare(strict_types = 1);

namespace Transform;

use Jira\JiraIssue;

class TsvMatrixTransformer
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
        $sprintPerformanceRows = [];

        $people = [self::UNDEFINED_ASSIGNEE, self::UNDEFINED_REVIEWER];
        $sprints = [self::UNDEFINED_SPRINT];

        foreach ($issues as $issue) {
            if ($issue->hasAssignee() === true && in_array($issue->getAssignee(), $people) === false) {
                $people[] = $issue->getAssignee();
            }
            if ($issue->hasReviewer() === true && in_array($issue->getReviewer(), $people) === false) {
                $people[] = $issue->getReviewer();
            }
            if ($issue->hasSprintKey() === true && in_array($issue->getSprintKey(), $sprints) === false) {
                $sprints[] = $issue->getSprintKey();
            }
        }

        foreach ($sprints as $sprint) {
            foreach ($people as $person) {
                $sprintPerformanceRows[$sprint][sprintf('%s_assigned', $person)] = 0.0;
                $sprintPerformanceRows[$sprint][sprintf('%s_shipped', $person)] = 0.0;
                $sprintPerformanceRows[$sprint][sprintf('%s_total', $person)] = 0.0;
            }
        }

        foreach ($sprints as $sprint) {
            foreach ($people as $person) {
                foreach ($issues as $issue) {
                    $issueSprint = $issue->hasSprintKey() ? $issue->getSprintKey() : self::UNDEFINED_SPRINT;
                    $storyPoints = $issue->hasStoryPoints() ? $issue->getStoryPoints() : 0;
                    $assignee = $issue->hasAssignee() ? $issue->getAssignee() : self::UNDEFINED_ASSIGNEE;
                    $reviewer = $issue->hasReviewer() ? $issue->getReviewer() : self::UNDEFINED_REVIEWER;

                    if ($sprint === $issueSprint && $person === $assignee) {
                        $sprintPerformanceRows[$sprint][sprintf('%s_assigned', $person)] += $storyPoints;
                        $sprintPerformanceRows[$sprint][sprintf('%s_total', $person)] += $storyPoints;
                    }
                    if ($sprint === $issueSprint && $person === $reviewer) {
                        $sprintPerformanceRows[$sprint][sprintf('%s_shipped', $person)] += $storyPoints;
                        $sprintPerformanceRows[$sprint][sprintf('%s_total', $person)] += $storyPoints;
                    }
                }

            };
        }

        uksort(
            $sprintPerformanceRows,
            function ($keyA, $keyB) {
                $aDoesMatch = preg_match_all('~\d+~', $keyA, $matchesA);
                $bDoesMatch = preg_match_all('~\d+~', $keyB, $matchesB);

                if ($aDoesMatch === 0 || $bDoesMatch === 0) {
                    return $aDoesMatch <=> $bDoesMatch;
                }

                return $matchesA[0][0] <=> $matchesB[0][0];
            }
        );

        return $sprintPerformanceRows;
    }
}