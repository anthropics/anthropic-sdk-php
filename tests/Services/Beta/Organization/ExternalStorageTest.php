<?php

namespace Tests\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ExternalStorage\DeletedExternalStorage;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorage;
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
final class ExternalStorageTest extends TestCase
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
        $result = $this->client->beta->organization->externalStorage->create(
            providerConfig: [
                'accountID' => '111122223333',
                'bucketName' => 'acme-safety-retention',
                'region' => 'us-east-2',
                'type' => 'aws',
            ],
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalStorage::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->externalStorage->create(
            providerConfig: [
                'accountID' => '111122223333',
                'bucketName' => 'acme-safety-retention',
                'region' => 'us-east-2',
                'type' => 'aws',
            ],
            displayName: 'x',
            userProfileID: 'uprof_01SDCCSbTxrXDpWc1phhtcfK',
            betas: [AnthropicBeta::COMPUTER_USE_2024_10_22],
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalStorage::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->organization->externalStorage->retrieve(
            'external_storage_id',
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalStorage::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->organization->externalStorage->update(
            'external_storage_id',
            displayName: 'x',
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalStorage::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->externalStorage->update(
            'external_storage_id',
            displayName: 'x',
            betas: [AnthropicBeta::COMPUTER_USE_2024_10_22],
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalStorage::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->externalStorage->list(
            requestOptions: ['extraQueryParams' => ['beta' => 'true']]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(ExternalStorage::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->organization->externalStorage->delete(
            'external_storage_id',
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeletedExternalStorage::class, $result);
    }

    #[Test]
    public function testActivate(): void
    {
        $result = $this->client->beta->organization->externalStorage->activate(
            'external_storage_id',
            requestOptions: ['extraQueryParams' => ['beta' => 'true']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalStorage::class, $result);
    }
}
