<?php

declare(strict_types = 1);

namespace Jira\Extract;

class AssigneeNameExtractorTest extends \AbstractTestCase
{

    /** @var \Jira\Extract\AssigneeNameExtractor */
    private $assigneeNameExtractor;

    protected function setUp(): void
    {
        $this->assigneeNameExtractor = new AssigneeNameExtractor();
    }

    /**
     * @dataProvider provideDataForGetAssigneeName
     */
    public function testGetAssigneeName(string $issueData, ?string $expectedResult)
    {
        self::assertEquals(
            $expectedResult,
            $this->assigneeNameExtractor->getAssigneeName(json_decode($issueData, true)['fields'])
        );
    }

    public function provideDataForGetAssigneeName()
    {
        return [
            [
                file_get_contents(__DIR__ . '/../fixture/0.json'),
                null,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/1.json'),
                'Ondra Silný',
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/2.json'),
                'Michal Velký',
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/3.json'),
                null,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/4.json'),
                'Tomáš Válčící',
            ],
        ];
    }

}