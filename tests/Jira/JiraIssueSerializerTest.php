<?php

declare(strict_types = 1);

namespace Jira;

use Jira\Extract\AssigneeNameExtractor;
use Jira\Extract\ReviewerNameExtractor;
use Jira\Extract\SprintNameExtractor;
use Jira\Extract\StoryPointExtractor;

class JiraIssueSerializerTest extends \AbstractTestCase
{

    /** @var \Jira\JiraIssueSerializer */
    private $testedClass;

    protected function setUp(): void
    {
        $this->testedClass = new JiraIssueSerializer(
            new SprintNameExtractor(),
            new AssigneeNameExtractor(),
            new ReviewerNameExtractor(),
            new StoryPointExtractor()
        );
    }

    /**
     * @dataProvider provideDataForDeserialize
     *
     * @param string $jsonContents
     * @param JiraIssue $expectedResult
     */
    public function testDeserialize(string $jsonContents, JiraIssue $expectedResult)
    {
        self::assertEquals(
            $expectedResult,
            $this->testedClass->deserialize(json_decode($jsonContents, true))
        );
    }

    public function provideDataForDeserialize()
    {
        return [
            'null api response' => [
                file_get_contents(__DIR__ . '/fixture/0.json'),
                new JiraIssue(
                    'DRV-583',
                    null,
                    null,
                    null,
                    null,
                ),
            ],
            'normal issue without reviewer' => [
                file_get_contents(__DIR__ . '/fixture/1.json'),
                new JiraIssue(
                    'DRV-567',
                    'DRIV Sprint 27',
                    'Ondra Silný',
                    null,
                    2
                ),
            ],
            'issue moving between sprints' => [
                file_get_contents(__DIR__ . '/fixture/2.json'),
                new JiraIssue(
                    'DRV-520',
                    'DRIV Sprint 26',
                    'Michal Velký',
                    'Ondra Silný',
                    5
                ),
            ],
            'issue in backlog' => [
                file_get_contents(__DIR__ . '/fixture/3.json'),
                new JiraIssue(
                    'DRV-82',
                    null,
                    null,
                    null,
                    0,
                ),
            ],
            'normal issue' => [
                file_get_contents(__DIR__ . '/fixture/4.json'),
                new JiraIssue(
                    'DRV-558',
                    'DRIV Sprint 25',
                    'Tomáš Válčící',
                    'Michal Velký',
                    0.5,
                ),
            ],
        ];
    }

}