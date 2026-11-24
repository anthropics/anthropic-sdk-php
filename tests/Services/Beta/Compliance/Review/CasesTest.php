<?php

namespace Tests\Services\Beta\Compliance\Review;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCase;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewDetermination;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewViolatedPolicyCategory;
use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class CasesTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'my-anthropic-api-key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->compliance->review->cases->retrieve(
            'case_id',
            requestOptions: ['extraQueryParams' => ['beta' => 'true']]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaComplianceReviewCase::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->compliance->review->cases->list(
            requestOptions: ['extraQueryParams' => ['beta' => 'true']]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaComplianceReviewCase::class, $item);
        }
    }

    #[Test]
    public function testRespond(): void
    {
        $result = $this->client->beta->compliance->review->cases->respond(
            'case_id',
            determination: BetaComplianceReviewDetermination::NO_VIOLATION,
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaComplianceReviewCase::class, $result);
    }

    #[Test]
    public function testRespondWithOptionalParams(): void
    {
        $result = $this->client->beta->compliance->review->cases->respond(
            'case_id',
            determination: BetaComplianceReviewDetermination::NO_VIOLATION,
            policyCategories: [BetaComplianceReviewViolatedPolicyCategory::CYBER],
            verdicts: [
                [
                    'determination' => BetaComplianceReviewDetermination::VIOLATION,
                    'itemID' => 'item_id',
                    'policyCategory' => BetaComplianceReviewViolatedPolicyCategory::CYBER,
                ],
            ],
            betas: [AnthropicBeta::COMPUTER_USE_2024_10_22],
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaComplianceReviewCase::class, $result);
    }
}
