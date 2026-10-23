<?php

namespace Tests\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\TelemetryDestinations\DeletedTelemetryDestination;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestination;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationContentMode;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestResponse;
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
final class TelemetryDestinationsTest extends TestCase
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
    public function testCreate(): void
    {
        $result = $this->client->beta->organization->telemetryDestinations->create(
            endpointURL: 'x',
            workspaces: ['type' => 'all'],
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TelemetryDestination::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->telemetryDestinations->create(
            endpointURL: 'x',
            workspaces: ['type' => 'all'],
            displayName: 'display_name',
            headers: ['foo' => 'string'],
            traces: [
                'contentMode' => TelemetryDestinationContentMode::METADATA_ONLY,
                'enabled' => true,
                'endpointURL' => 'endpoint_url',
                'maxContentBytes' => 0,
            ],
            betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TelemetryDestination::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->telemetryDestinations
            ->retrieve(
                'destination_id',
                requestOptions: ['extraQueryParams' => ['beta' => 'true']],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TelemetryDestination::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->organization->telemetryDestinations->update(
            'destination_id',
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TelemetryDestination::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->telemetryDestinations->list(
            requestOptions: ['extraQueryParams' => ['beta' => 'true']]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(TelemetryDestination::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->organization->telemetryDestinations->delete(
            'destination_id',
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeletedTelemetryDestination::class, $result);
    }

    #[Test]
    public function testTest(): void
    {
        $result = $this->client->beta->organization->telemetryDestinations->test(
            'destination_id',
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TelemetryDestinationTestResponse::class, $result);
    }
}
