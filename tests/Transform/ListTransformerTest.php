<?php

declare(strict_types = 1);

namespace Transform;

use Jira\JiraIssue;

class ListTransformerTest extends \AbstractTestCase
{

    /** @var \Transform\ListTransformer */
    private $listTransformer;

    protected function setUp(): void
    {
        $this->listTransformer = new ListTransformer();
    }

    /**
     * @dataProvider provideDataForTransform
     */
    public function testTransform(array $issueInput, array $expectedResult)
    {
        self::assertEquals(
            $expectedResult,
            $this->listTransformer->transform($issueInput)
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
                        'undefined_assignee' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'undefined_reviewer' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Franta' => [
                            'assignedAmount' => 4,
                            'assignedIssues' => ['DRV-0'],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Tomáš' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 4,
                            'shippedIssues' => ['DRV-0'],
                        ],
                        'Kristýna' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Marie' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                    ],
                    'sprint 2' => [
                        'undefined_assignee' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'undefined_reviewer' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Franta' => [
                            'assignedAmount' => 2,
                            'assignedIssues' => ['DRV-2'],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Tomáš' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Kristýna' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 2,
                            'shippedIssues' => ['DRV-2'],
                        ],
                        'Marie' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                    ],
                    'sprint 3' => [
                        'undefined_assignee' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'undefined_reviewer' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Franta' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Tomáš' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Kristýna' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 3,
                            'shippedIssues' => ['DRV-3'],
                        ],
                        'Marie' => [
                            'assignedAmount' => 3,
                            'assignedIssues' => ['DRV-3'],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                    ],
                    'sprint 11' => [
                        'undefined_assignee' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'undefined_reviewer' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Franta' => [
                            'assignedAmount' => 1,
                            'assignedIssues' => ['DRV-1'],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Tomáš' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 1,
                            'shippedIssues' => ['DRV-1'],
                        ],
                        'Kristýna' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                        'Marie' => [
                            'assignedAmount' => 0,
                            'assignedIssues' => [],
                            'shippedAmount' => 0,
                            'shippedIssues' => [],
                        ],
                    ],
                ],
            ],
        ];
    }

}