<?php

namespace Tests\Services\Beta;

use Anthropic\Beta\Environments\BetaEnvironment;
use Anthropic\Beta\Environments\BetaEnvironmentDeleteResponse;
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
final class EnvironmentsTest extends TestCase
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
        $result = $this->client->beta->environments->create(
            name: 'python-data-analysis'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaEnvironment::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->environments->create(
            name: 'python-data-analysis',
            config: [
                'type' => 'cloud',
                'networking' => [
                    'type' => 'limited',
                    'allowMCPServers' => true,
                    'allowPackageManagers' => true,
                    'allowedHosts' => ['api.example.com'],
                ],
                'packages' => [
                    'apt' => ['string'],
                    'cargo' => ['string'],
                    'gem' => ['string'],
                    'go' => ['string'],
                    'npm' => ['string'],
                    'pip' => ['pandas', 'numpy'],
                    'type' => 'packages',
                ],
            ],
            description: 'Python environment with data-analysis packages.',
            metadata: ['foo' => 'string'],
            betas: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaEnvironment::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->environments->retrieve(
            'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaEnvironment::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->environments->update(
            'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaEnvironment::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->environments->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaEnvironment::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->environments->delete(
            'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaEnvironmentDeleteResponse::class, $result);
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->beta->environments->archive(
            'env_011CZkZ9X2dpNyB7HsEFoRfW'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaEnvironment::class, $result);
    }
}
