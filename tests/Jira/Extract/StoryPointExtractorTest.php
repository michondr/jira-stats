<?php

declare(strict_types = 1);

namespace Jira\Extract;

class StoryPointExtractorTest extends \AbstractTestCase
{

    /** @var \Jira\Extract\StoryPointExtractor */
    private $storyPointExtractor;

    protected function setUp(): void
    {
        $this->storyPointExtractor = new StoryPointExtractor();
    }

    /**
     * @dataProvider provideDataForGetStoryPoint
     */
    public function testGetStoryPoint(string $issueData, ?float $expectedResult)
    {
        self::assertEquals(
            $expectedResult,
            $this->storyPointExtractor->getStoryPoints(json_decode($issueData, true)['fields'])
        );
    }

    public function provideDataForGetStoryPoint()
    {
        return [
            [
                file_get_contents(__DIR__ . '/../fixture/0.json'),
                null,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/1.json'),
                2,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/2.json'),
                5,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/3.json'),
                null,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/4.json'),
                0.5,
            ],
        ];
    }

}