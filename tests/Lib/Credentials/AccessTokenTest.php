<?php

declare(strict_types=1);

namespace Tests\Lib\Credentials;

use Anthropic\Lib\Credentials\AccessToken;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class AccessTokenTest extends TestCase
{
    public function testIsExpiredWithNoExpiry(): void
    {
        $token = new AccessToken('tok_abc');
        $this->assertFalse($token->isExpired());
        $this->assertFalse($token->isExpired(3600));
    }

    public function testIsExpiredWithFutureExpiry(): void
    {
        $token = new AccessToken('tok_abc', time() + 600);
        $this->assertFalse($token->isExpired());
    }

    public function testIsExpiredWithPastExpiry(): void
    {
        $token = new AccessToken('tok_abc', time() - 10);
        $this->assertTrue($token->isExpired());
    }

    public function testIsExpiredWithBuffer(): void
    {
        // Token expires in 60 seconds, but buffer is 120 seconds.
        $token = new AccessToken('tok_abc', time() + 60);
        $this->assertFalse($token->isExpired(30));
        $this->assertTrue($token->isExpired(120));
    }

    public function testProperties(): void
    {
        $token = new AccessToken('my-token', 1234567890);
        $this->assertSame('my-token', $token->token);
        $this->assertSame(1234567890, $token->expiresAt);
    }

    public function testNullExpiry(): void
    {
        $token = new AccessToken('tok');
        $this->assertNull($token->expiresAt);
    }
}
