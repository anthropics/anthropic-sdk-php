<?php

namespace Tests\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidationReport;
use Anthropic\Client;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class PluginMarketplacesTest extends TestCase
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
        $result = $this->client->beta->organization->pluginMarketplaces->retrieve(
            'marketplace_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PluginMarketplace::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->organization->pluginMarketplaces->update(
            'marketplace_id',
            defaultInstallationPreference: 'available'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PluginMarketplace::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->pluginMarketplaces->update(
            'marketplace_id',
            defaultInstallationPreference: 'available',
            betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PluginMarketplace::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->pluginMarketplaces->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(PluginMarketplace::class, $item);
        }
    }

    #[Test]
    public function testValidateArchive(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->pluginMarketplaces
            ->validateArchive(
                archive: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PluginMarketplaceValidationReport::class, $result);
    }

    #[Test]
    public function testValidateArchiveWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->pluginMarketplaces
            ->validateArchive(
                archive: FileParam::fromString('Example data', filename: uniqid('file-upload-', true)),
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PluginMarketplaceValidationReport::class, $result);
    }

    #[Test]
    public function testValidateRepository(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->pluginMarketplaces
            ->validateRepository(
                repositoryURL: 'https://github.com/example-org/example-marketplace'
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PluginMarketplaceValidationReport::class, $result);
    }

    #[Test]
    public function testValidateRepositoryWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->pluginMarketplaces
            ->validateRepository(
                repositoryURL: 'https://github.com/example-org/example-marketplace',
                ref: 'main',
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PluginMarketplaceValidationReport::class, $result);
    }
}
