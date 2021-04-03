<?php

declare(strict_types = 1);

namespace Jira;

class JiraIssue
{
    private string $id;
    private ?string $sprintKey;
    private ?string $assignee;
    private ?string $reviewer;
    private ?float $storyPoints;

    public function __construct(
        string $id,
        ?string $sprintKey,
        ?string $assignee,
        ?string $reviewer,
        ?float $storyPoints
    )
    {
        $this->id = $id;
        $this->sprintKey = $sprintKey;
        $this->assignee = $assignee;
        $this->reviewer = $reviewer;
        $this->storyPoints = $storyPoints;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSprintKey(): string
    {
        return $this->sprintKey;
    }

    public function hasSprintKey(): bool
    {
        return $this->sprintKey !== null;
    }

    public function getAssignee(): string
    {
        return str_replace(' ', '_', $this->assignee);
    }

    public function hasAssignee(): bool
    {
        return $this->assignee !== null;
    }

    public function getReviewer(): string
    {
        return str_replace(' ', '_', $this->reviewer);
    }

    public function hasReviewer(): bool
    {
        return $this->reviewer !== null;
    }

    public function getStoryPoints(): float
    {
        return $this->storyPoints;
    }

    public function hasStoryPoints(): bool
    {
        return $this->storyPoints !== null;
    }
}