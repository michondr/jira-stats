<?php

declare(strict_types = 1);

namespace Transform;

use Jira\JiraIssue;

class TsvMatrixTransformerTest extends \AbstractTestCase
{

    /** @var \Transform\TsvMatrixTransformer */
    private $tsvMatrixTransformer;

    protected function setUp(): void
    {
        $this->tsvMatrixTransformer = new TsvMatrixTransformer();
    }

    /**
     * @dataProvider provideDataForTransform
     */
    public function testTransform(array $issueInput, array $expectedResult)
    {
        self::assertEquals(
            $expectedResult,
            $this->tsvMatrixTransformer->transform($issueInput)
        );
    }

    public function provideDataForTransform()
    {
        return [
            [
                [
                    new JiraIssue(
                        'DRV-1',
                        'sprint 11',
                        'Franta',
                        'Tomáš',
                        1
                    ),
                    new JiraIssue(
                        'DRV-2',
                        'sprint 2',
                        'Franta',
                        'Kristýna',
                        2
                    ),
                    new JiraIssue(
                        'DRV-3',
                        'sprint 3',
                        'Marie',
                        'Kristýna',
                        3
                    ),
                    new JiraIssue(
                        'DRV-0',
                        null,
                        'Franta',
                        'Tomáš',
                        4
                    ),
                ],
                [
                    'undefined_sprint' => [
                        'undefined_assignee_assigned' => 0.0,
                        'undefined_assignee_shipped' => 0.0,
                        'undefined_assignee_total' => 0.0,
                        'undefined_reviewer_assigned' => 0.0,
                        'undefined_reviewer_shipped' => 0.0,
                        'undefined_reviewer_total' => 0.0,
                        'Franta_assigned' => 4.0,
                        'Franta_shipped' => 0.0,
                        'Franta_total' => 4.0,
                        'Tomáš_assigned' => 0.0,
                        'Tomáš_shipped' => 4.0,
                        'Tomáš_total' => 4.0,
                        'Kristýna_assigned' => 0.0,
                        'Kristýna_shipped' => 0.0,
                        'Kristýna_total' => 0.0,
                        'Marie_assigned' => 0.0,
                        'Marie_shipped' => 0.0,
                        'Marie_total' => 0.0,
                    ],
                    'sprint 2' => [
                        'undefined_assignee_assigned' => 0.0,
                        'undefined_assignee_shipped' => 0.0,
                        'undefined_assignee_total' => 0.0,
                        'undefined_reviewer_assigned' => 0.0,
                        'undefined_reviewer_shipped' => 0.0,
                        'undefined_reviewer_total' => 0.0,
                        'Franta_assigned' => 2,
                        'Franta_shipped' => 0.0,
                        'Franta_total' => 2,
                        'Tomáš_assigned' => 0.0,
                        'Tomáš_shipped' => 0.0,
                        'Tomáš_total' => 0.0,
                        'Kristýna_assigned' => 0.0,
                        'Kristýna_shipped' => 2,
                        'Kristýna_total' => 2,
                        'Marie_assigned' => 0.0,
                        'Marie_shipped' => 0.0,
                        'Marie_total' => 0.0,
                    ],
                    'sprint 3' => [
                        'undefined_assignee_assigned' => 0.0,
                        'undefined_assignee_shipped' => 0.0,
                        'undefined_assignee_total' => 0.0,
                        'undefined_reviewer_assigned' => 0.0,
                        'undefined_reviewer_shipped' => 0.0,
                        'undefined_reviewer_total' => 0.0,
                        'Franta_assigned' => 0.0,
                        'Franta_shipped' => 0.0,
                        'Franta_total' => 0.0,
                        'Tomáš_assigned' => 0.0,
                        'Tomáš_shipped' => 0.0,
                        'Tomáš_total' => 0.0,
                        'Kristýna_assigned' => 0.0,
                        'Kristýna_shipped' => 3.0,
                        'Kristýna_total' => 3.0,
                        'Marie_assigned' => 3.0,
                        'Marie_shipped' => 0.0,
                        'Marie_total' => 3.0,
                    ],
                    'sprint 11' => [
                        'undefined_assignee_assigned' => 0.0,
                        'undefined_assignee_shipped' => 0.0,
                        'undefined_assignee_total' => 0.0,
                        'undefined_reviewer_assigned' => 0.0,
                        'undefined_reviewer_shipped' => 0.0,
                        'undefined_reviewer_total' => 0.0,
                        'Franta_assigned' => 1,
                        'Franta_shipped' => 0.0,
                        'Franta_total' => 1,
                        'Tomáš_assigned' => 0.0,
                        'Tomáš_shipped' => 1,
                        'Tomáš_total' => 1,
                        'Kristýna_assigned' => 0.0,
                        'Kristýna_shipped' => 0.0,
                        'Kristýna_total' => 0.0,
                        'Marie_assigned' => 0.0,
                        'Marie_shipped' => 0.0,
                        'Marie_total' => 0.0,
                    ],
                ],
            ],
        ];
    }
}