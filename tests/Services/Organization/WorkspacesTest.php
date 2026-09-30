<?php

namespace Tests\Services\Organization;

use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Organization\Workspaces\Workspace;
use Anthropic\Page;
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
    public function testCreate(): void
    {
        $result = $this->client->organization->workspaces->create(name: 'x');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Workspace::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->organization->workspaces->create(
            name: 'x',
            dataResidency: [
                'allowedInferenceGeos' => 'unrestricted',
                'defaultInferenceGeo' => 'global',
                'workspaceGeo' => 'us',
            ],
            displayColor: '#6C5BB9',
            externalKeyID: 'ekey_01SDCCSbTxrXDpWc1phhtcfK',
            tags: ['env' => 'prod', 'team' => 'platform'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Workspace::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->organization->workspaces->retrieve('workspace_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Workspace::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->organization->workspaces->update('workspace_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Workspace::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $page = $this->client->organization->workspaces->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Page::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(Workspace::class, $item);
        }
    }

    #[Test]
    public function testArchive(): void
    {
        $result = $this->client->organization->workspaces->archive('workspace_id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Workspace::class, $result);
    }
}
