<?php

declare(strict_types = 1);

namespace Transform;

use Jira\JiraIssue;

class SprintStatsTransformer
{
    private const UNDEFINED_SPRINT = 'undefined_sprint';
    private const UNDEFINED_ASSIGNEE = 'undefined_assignee';
    private const UNDEFINED_REVIEWER = 'undefined_reviewer';

    private const ASSIGNED_AMOUNT = 'assignedAmount';
    private const ASSIGNED_ISSUES = 'assignedIssues';
    private const SHIPPED_AMOUNT = 'shippedAmount';
    private const SHIPPED_ISSUES = 'shippedIssues';

    public function transform(array $issues): array
    {
        $sprintPerformance = [];
        /** @var JiraIssue $issue */

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

            if ($issue->hasSprintKey()) {
                $sprint = $issue->getSprintKey();
            } else {
                $sprint = self::UNDEFINED_SPRINT;
            }

            if ($issue->hasStoryPoints() === true) {
                $storyPoints = $issue->getStoryPoints();
            } else {
                $storyPoints = 0;
            }

            $sprintPerformance[$sprint][$issue->getAssignee()][self::ASSIGNED_AMOUNT] += $storyPoints;
            $sprintPerformance[$sprint][$issue->getAssignee()][self::ASSIGNED_ISSUES][] = $issue->getId();
            $sprintPerformance[$sprint][$issue->getReviewer()][self::SHIPPED_AMOUNT] += $storyPoints;
            $sprintPerformance[$sprint][$issue->getReviewer()][self::SHIPPED_ISSUES][] = $issue->getId();
        }

        return $sprintPerformance;
    }
}