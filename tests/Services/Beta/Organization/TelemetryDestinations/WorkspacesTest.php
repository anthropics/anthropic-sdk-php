<?php

namespace Tests\Services\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\BetaDeletedTelemetryDestinationWorkspace;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\BetaTelemetryDestinationWorkspace;
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
final class WorkspacesTest extends TestCase
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
    public function testList(): void
    {
        $page = $this
            ->client
            ->beta
            ->organization
            ->telemetryDestinations
            ->workspaces
            ->list('destination_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaTelemetryDestinationWorkspace::class, $item);
        }
    }

    #[Test]
    public function testAdd(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->telemetryDestinations
            ->workspaces
            ->add('workspace_id', destinationID: 'destination_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaTelemetryDestinationWorkspace::class, $result);
    }

    #[Test]
    public function testAddWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->telemetryDestinations
            ->workspaces
            ->add(
                'workspace_id',
                destinationID: 'destination_id',
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaTelemetryDestinationWorkspace::class, $result);
    }

    #[Test]
    public function testRemove(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->telemetryDestinations
            ->workspaces
            ->remove('workspace_id', destinationID: 'destination_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaDeletedTelemetryDestinationWorkspace::class,
            $result
        );
    }

    #[Test]
    public function testRemoveWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->telemetryDestinations
            ->workspaces
            ->remove(
                'workspace_id',
                destinationID: 'destination_id',
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaDeletedTelemetryDestinationWorkspace::class,
            $result
        );
    }
}
