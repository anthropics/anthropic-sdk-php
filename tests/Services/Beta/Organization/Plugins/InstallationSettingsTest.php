<?php

namespace Tests\Services\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaDeletedPluginInstallationSetting;
use Anthropic\Beta\Organization\Plugins\InstallationSettings\BetaPluginInstallationSetting;
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
final class InstallationSettingsTest extends TestCase
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
            ->plugins
            ->installationSettings
            ->list('plugin_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PageCursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BetaPluginInstallationSetting::class, $item);
        }
    }

    #[Test]
    public function testRemove(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->plugins
            ->installationSettings
            ->remove('target', pluginID: 'plugin_id')
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaDeletedPluginInstallationSetting::class,
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
            ->plugins
            ->installationSettings
            ->remove(
                'target',
                pluginID: 'plugin_id',
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            BetaDeletedPluginInstallationSetting::class,
            $result
        );
    }

    #[Test]
    public function testSet(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->plugins
            ->installationSettings
            ->set(
                'target',
                pluginID: 'plugin_id',
                installationPreference: 'required'
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaPluginInstallationSetting::class, $result);
    }

    #[Test]
    public function testSetWithOptionalParams(): void
    {
        $result = $this
            ->client
            ->beta
            ->organization
            ->plugins
            ->installationSettings
            ->set(
                'target',
                pluginID: 'plugin_id',
                installationPreference: 'required',
                betas: [AnthropicBeta::MESSAGE_BATCHES_2024_09_24],
            )
        ;

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BetaPluginInstallationSetting::class, $result);
    }
}
