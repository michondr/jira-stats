<?php

declare(strict_types = 1);

namespace Transform;

use Jira\JiraIssue;

class ListTransformer
{
    private const UNDEFINED_SPRINT = 'undefined_sprint';
    private const UNDEFINED_ASSIGNEE = 'undefined_assignee';
    private const UNDEFINED_REVIEWER = 'undefined_reviewer';

    private const ASSIGNED_AMOUNT = 'assignedAmount';
    private const ASSIGNED_ISSUES = 'assignedIssues';
    private const SHIPPED_AMOUNT = 'shippedAmount';
    private const SHIPPED_ISSUES = 'shippedIssues';

    /**
     * @param JiraIssue[] $issues
     * @return array
     */
    public function transform(array $issues): array
    {
        $sprintPerformance = [];

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
                $sprintPerformance[$sprint][$person][self::ASSIGNED_AMOUNT] = 0;
                $sprintPerformance[$sprint][$person][self::ASSIGNED_ISSUES] = [];
                $sprintPerformance[$sprint][$person][self::SHIPPED_AMOUNT] = 0;
                $sprintPerformance[$sprint][$person][self::SHIPPED_ISSUES] = [];
            }
        }

        foreach ($issues as $issue) {
            $sprint = $issue->hasSprintKey() ? $issue->getSprintKey() : self::UNDEFINED_SPRINT;
            $storyPoints = $issue->hasStoryPoints() ? $issue->getStoryPoints() : 0;
            $assignee = $issue->hasAssignee() ? $issue->getAssignee() : self::UNDEFINED_ASSIGNEE;
            $reviewer = $issue->hasReviewer() ? $issue->getReviewer() : self::UNDEFINED_REVIEWER;

            $sprintPerformance[$sprint][$assignee][self::ASSIGNED_AMOUNT] += $storyPoints;
            $sprintPerformance[$sprint][$assignee][self::ASSIGNED_ISSUES][] = $issue->getId();
            $sprintPerformance[$sprint][$reviewer][self::SHIPPED_AMOUNT] += $storyPoints;
            $sprintPerformance[$sprint][$reviewer][self::SHIPPED_ISSUES][] = $issue->getId();
        }

        uksort(
            $sprintPerformance,
            function ($keyA, $keyB) {
                $aDoesMatch = preg_match_all('~\d+~', $keyA, $matchesA);
                $bDoesMatch = preg_match_all('~\d+~', $keyB, $matchesB);

                if ($aDoesMatch === 0 || $bDoesMatch === 0) {
                    return $aDoesMatch <=> $bDoesMatch;
                }

                return $matchesA[0][0] <=> $matchesB[0][0];
            }
        );

        return $sprintPerformance;
    }
}