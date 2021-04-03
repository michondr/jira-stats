<?php

declare(strict_types = 1);

namespace Transform;

use Jira\JiraIssue;

class TsvTransformerTest extends \AbstractTestCase
{

    /** @var \Transform\TsvTransformer */
    private $tsvTransformer;

    protected function setUp(): void
    {
        $this->tsvTransformer = new TsvTransformer();
    }

    /**
     * @dataProvider provideDataForTransform
     */
    public function testTransform(array $issueInput, array $expectedResult)
    {
        self::assertEquals(
            $expectedResult,
            $this->tsvTransformer->transform($issueInput)
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
                    [
                        0 => 'sprintName',
                        1 => 'issue',
                        2 => 'assignee',
                        3 => 'reviewer',
                        4 => 'story_points',
                    ],
                    [
                        0 => 'undefined_sprint',
                        1 => 'DRV-0',
                        2 => 'Franta',
                        3 => 'Tomáš',
                        4 => 4.0,
                    ],

                    [
                        0 => 'sprint 2',
                        1 => 'DRV-2',
                        2 => 'Franta',
                        3 => 'Kristýna',
                        4 => 2.0,
                    ],
                    [
                        0 => 'sprint 3',
                        1 => 'DRV-3',
                        2 => 'Marie',
                        3 => 'Kristýna',
                        4 => 3.0,
                    ],
                    [
                        0 => 'sprint 11',
                        1 => 'DRV-1',
                        2 => 'Franta',
                        3 => 'Tomáš',
                        4 => 1.0,
                    ],
                ],
            ],
        ];
    }

}