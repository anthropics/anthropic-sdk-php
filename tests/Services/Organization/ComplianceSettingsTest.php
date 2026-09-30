<?php

namespace Tests\Services\Organization;

use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Organization\ComplianceSettings\OrganizationComplianceSettings;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
final class ComplianceSettingsTest extends TestCase
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
        $result = $this->client->organization->complianceSettings->retrieve();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(OrganizationComplianceSettings::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->organization->complianceSettings->update(
            state: ['type' => 'enabled']
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(OrganizationComplianceSettings::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->organization->complianceSettings->update(
            state: ['type' => 'enabled']
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(OrganizationComplianceSettings::class, $result);
    }
}
