<?php

namespace Tests\Services\Organization\Federation;

use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Organization\Federation\Rules\FederationRule;
use Anthropic\PageCursor;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class RulesTest extends TestCase
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
        $result = $this->client->organization->federation->rules->create(
            issuerID: 'issuer_id',
            match: [],
            name: 'x',
            oauthScope: 'x',
            target: [
                'serviceAccountID' => 'svac_01SDCCSbTxrXDpWc1phhtcfK',
                'type' => 'service_account',
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FederationRule::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->organization->federation->rules->create(
            issuerID: 'issuer_id',
            match: [
                'audience' => 'audience',
                'claims' => ['foo' => 'string'],
                'condition' => 'condition',
                'subjectPrefix' => 'subject_prefix',
            ],
            name: 'x',
            oauthScope: 'x',
            target: [
                'serviceAccountID' => 'svac_01SDCCSbTxrXDpWc1phhtcfK',
                'type' => 'service_account',
                'serviceAccountName' => 'service_account_name',
            ],
            appliesToAllWorkspaces: true,
            description: 'description',
            tokenLifetimeSeconds: 60,
            workspaceID: 'workspace_id',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FederationRule::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->organization->federation->rules->retrieve(
            'federation_rule_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FederationRule::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->organization->federation->rules->update(
            'federation_rule_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FederationRule::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->organization->federation->rules->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(FederationRule::class, $item);
        }
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->organization->federation->rules->archive(
            'federation_rule_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FederationRule::class, $result);
    }
}
