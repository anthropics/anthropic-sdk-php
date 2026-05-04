<?php

declare(strict_types=1);

namespace Tests\Lib\Credentials;

use Anthropic\Lib\Credentials\IdentityTokenFile;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class IdentityTokenFileTest extends TestCase
{
    private string $tmpDir;

    protected function setUp(): void
    {
        $this->tmpDir = sys_get_temp_dir().'/anthropic_test_'.uniqid();
        mkdir($this->tmpDir, 0755, true);
    }

    protected function tearDown(): void
    {
        // Clean up temp files.
        $files = glob($this->tmpDir.'/*') ?: [];
        foreach ($files as $file) {
            unlink($file);
        }
        @rmdir($this->tmpDir);
    }

    public function testReadsTokenFromFile(): void
    {
        $path = $this->tmpDir.'/token';
        file_put_contents($path, "  eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.test  \n");

        $provider = new IdentityTokenFile($path);
        $token = $provider->getIdentityToken();

        $this->assertSame('eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.test', $token);
    }

    public function testThrowsOnMissingFile(): void
    {
        $provider = new IdentityTokenFile('/nonexistent/path/token');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Failed to read identity token');

        $provider->getIdentityToken();
    }

    public function testReReadsOnEachCall(): void
    {
        $path = $this->tmpDir.'/token';
        file_put_contents($path, 'token_v1');

        $provider = new IdentityTokenFile($path);
        $this->assertSame('token_v1', $provider->getIdentityToken());

        // Simulate token rotation.
        file_put_contents($path, 'token_v2');
        $this->assertSame('token_v2', $provider->getIdentityToken());
    }
}
