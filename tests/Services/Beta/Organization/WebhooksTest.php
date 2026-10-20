<?php

namespace Tests\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Webhooks\DeletedOrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\NewOrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\OrganizationWebhookEndpoint;
use Anthropic\Beta\Organization\Webhooks\OrganizationWebhookEndpointSigningSecret;
use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Page;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class WebhooksTest extends TestCase
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
        $result = $this->client->beta->organization->webhooks->create(
            enabledEvents: ['user_profile.enforcement_action_opened'],
            url: 'x'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(NewOrganizationWebhookEndpoint::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->beta->organization->webhooks->create(
            enabledEvents: ['user_profile.enforcement_action_opened'],
            url: 'x',
            description: 'description',
            name: 'name',
            betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(NewOrganizationWebhookEndpoint::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->beta->organization->webhooks->retrieve(
            'webhook_endpoint_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(OrganizationWebhookEndpoint::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->beta->organization->webhooks->update(
            'webhook_endpoint_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(OrganizationWebhookEndpoint::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->beta->organization->webhooks->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Page::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(OrganizationWebhookEndpoint::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->beta->organization->webhooks->delete(
            'webhook_endpoint_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DeletedOrganizationWebhookEndpoint::class, $result);
    }

    #[Test]
    public function testRegenerateSigningSecret(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->webhooks
            ->regenerateSigningSecret('webhook_endpoint_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            OrganizationWebhookEndpointSigningSecret::class,
            $result
        );
    }
}
