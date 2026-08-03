<?php

declare(strict_types=1);

namespace Tests\Core;

use Anthropic\Client;
use Http\Discovery\ClassDiscovery;
use Http\Discovery\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class HttpDiscoveryTest extends TestCase
{
    /** @var string[] */
    private array $originalStrategies;

    protected function setUp(): void
    {
        $this->originalStrategies = [...ClassDiscovery::getStrategies()];
    }

    protected function tearDown(): void
    {
        ClassDiscovery::setStrategies($this->originalStrategies);
    }

    public function testMissingClientErrorNamesTheFix(): void
    {
        ClassDiscovery::setStrategies([]);

        try {
            new Client(apiKey: 'sk-ant-test');
            $this->fail('Expected '.NotFoundException::class);
        } catch (NotFoundException $e) {
            $this->assertStringContainsString('composer require guzzlehttp/guzzle', $e->getMessage());
            $this->assertInstanceOf(NotFoundException::class, $e->getPrevious());
        }
    }
}
