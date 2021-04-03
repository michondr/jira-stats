<?php

declare(strict_types = 1);

namespace Jira\Extract;

class SprintNameExtractorTest extends \AbstractTestCase
{

    /** @var \Jira\Extract\SprintNameExtractor */
    private $sprintNameExtractor;

    protected function setUp(): void
    {
        $this->sprintNameExtractor = new SprintNameExtractor();
    }

    /**
     * @dataProvider provideDataForGetSprintName
     */
    public function testGetSprintName(string $issueData, ?string $expectedResult)
    {
        self::assertEquals(
            $expectedResult,
            $this->sprintNameExtractor->getSprintName(json_decode($issueData, true)['fields'])
        );
    }

    public function provideDataForGetSprintName()
    {
        return [
            [
                file_get_contents(__DIR__ . '/../fixture/0.json'),
                null,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/1.json'),
                'DRIV Sprint 27',
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/2.json'),
                'DRIV Sprint 26',
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/3.json'),
                null,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/4.json'),
                'DRIV Sprint 25',
            ],
        ];
    }

}