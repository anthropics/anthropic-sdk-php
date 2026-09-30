<?php

namespace Tests\Services\Organization;

use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Organization\ExternalKeys\ExternalKey;
use Anthropic\Organization\ExternalKeys\ExternalKeyDeleteResponse;
use Anthropic\Organization\ExternalKeys\ExternalKeyValidateResponse;
use Anthropic\PageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class ExternalKeysTest extends TestCase
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
        $result = $this->client->organization->externalKeys->create(
            providerConfig: [
                'kmsARN' => 'arn:aws:kms:us-east-1:111122223333:key/abcd1234-5678-90ab-cdef-000011112222',
                'type' => 'aws',
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalKey::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->organization->externalKeys->create(
            providerConfig: [
                'kmsARN' => 'arn:aws:kms:us-east-1:111122223333:key/abcd1234-5678-90ab-cdef-000011112222',
                'type' => 'aws',
                'region' => 'us-east-1',
            ],
            displayName: 'x',
            geo: 'us',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalKey::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->organization->externalKeys->retrieve(
            'external_key_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalKey::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->organization->externalKeys->update(
            'external_key_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalKey::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->organization->externalKeys->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(ExternalKey::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->organization->externalKeys->delete(
            'external_key_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalKeyDeleteResponse::class, $result);
    }

    #[Test]
    public function testValidate(): void
    {
        $result = $this->client->organization->externalKeys->validate(
            'external_key_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExternalKeyValidateResponse::class, $result);
    }
}
