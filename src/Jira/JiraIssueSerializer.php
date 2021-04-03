<?php

declare(strict_types = 1);

namespace Jira;

use Jira\Extract\AssigneeNameExtractor;
use Jira\Extract\ReviewerNameExtractor;
use Jira\Extract\SprintNameExtractor;
use Jira\Extract\StoryPointExtractor;

class JiraIssueSerializer
{

    private SprintNameExtractor $sprintNameExtractor;
    private AssigneeNameExtractor $assigneeNameExtractor;
    private ReviewerNameExtractor $reviewerNameExtractor;
    private StoryPointExtractor $storyPointExtractor;

    public function __construct(
        SprintNameExtractor $sprintNameExtractor,
        AssigneeNameExtractor $assigneeNameExtractor,
        ReviewerNameExtractor $reviewerNameExtractor,
        StoryPointExtractor $storyPointExtractor
    )
    {
        $this->sprintNameExtractor = $sprintNameExtractor;
        $this->assigneeNameExtractor = $assigneeNameExtractor;
        $this->reviewerNameExtractor = $reviewerNameExtractor;
        $this->storyPointExtractor = $storyPointExtractor;
    }

    public function deserialize(array $issueData): JiraIssue
    {
        $issueFields = $issueData['fields'];
        $id = $issueData['key'];

        return new JiraIssue(
            $id,
            $this->sprintNameExtractor->getSprintName($issueFields),
            $this->assigneeNameExtractor->getAssigneeName($issueFields),
            $this->reviewerNameExtractor->getReviewerName($issueFields),
            $this->storyPointExtractor->getStoryPoints($issueFields),
        );
    }

}