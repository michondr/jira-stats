<?php

declare(strict_types = 1);

namespace Jira\Extract;

class ReviewerNameExtractorTest extends \AbstractTestCase
{

    /** @var \Jira\Extract\ReviewerNameExtractor */
    private $reviewerNameExtractor;

    protected function setUp(): void
    {
        $this->reviewerNameExtractor = new ReviewerNameExtractor();
    }

    /**
     * @dataProvider provideDataForGetReviewerName
     */
    public function testGetReviewerName(string $issueData, ?string $expectedResult)
    {
        self::assertEquals(
            $expectedResult,
            $this->reviewerNameExtractor->getReviewerName(json_decode($issueData, true)['fields'])
        );
    }

    public function provideDataForGetReviewerName()
    {
        return [
            [
                file_get_contents(__DIR__ . '/../fixture/0.json'),
                null,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/1.json'),
                null,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/2.json'),
                'Ondra Silný',
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/3.json'),
                null,
            ],
            [
                file_get_contents(__DIR__ . '/../fixture/4.json'),
                'Michal Velký',
            ],
        ];
    }

}