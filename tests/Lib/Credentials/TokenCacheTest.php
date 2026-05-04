<?php

declare(strict_types=1);

namespace Tests\Lib\Credentials;

use Anthropic\Lib\Credentials\AccessToken;
use Anthropic\Lib\Credentials\AccessTokenProvider;
use Anthropic\Lib\Credentials\TokenCache;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class TokenCacheTest extends TestCase
{
    public function testCachesToken(): void
    {
        $callCount = 0;
        $inner = new class($callCount) implements AccessTokenProvider {
            public function __construct(private int &$callCount) {}

            public function fetchToken(): AccessToken
            {
                ++$this->callCount;

                return new AccessToken('tok_'.$this->callCount, time() + 600);
            }
        };

        $cache = new TokenCache($inner);

        $first = $cache->fetchToken();
        $second = $cache->fetchToken();

        $this->assertSame($first->token, $second->token);
        $this->assertSame(1, $callCount);
    }

    public function testRefreshesExpiredToken(): void
    {
        $callCount = 0;
        $inner = new class($callCount) implements AccessTokenProvider {
            public function __construct(private int &$callCount) {}

            public function fetchToken(): AccessToken
            {
                ++$this->callCount;

                // Return a token that is already within the advisory refresh window.
                return new AccessToken('tok_'.$this->callCount, time() + 60);
            }
        };

        $cache = new TokenCache($inner);

        $first = $cache->fetchToken();
        // Token expires within 120s (advisory threshold), so next call refreshes.
        $second = $cache->fetchToken();

        $this->assertNotSame($first->token, $second->token);
        $this->assertSame(2, $callCount);
    }

    public function testInvalidateForcesRefresh(): void
    {
        $callCount = 0;
        $inner = new class($callCount) implements AccessTokenProvider {
            public function __construct(private int &$callCount) {}

            public function fetchToken(): AccessToken
            {
                ++$this->callCount;

                return new AccessToken('tok_'.$this->callCount, time() + 3600);
            }
        };

        $cache = new TokenCache($inner);

        $first = $cache->fetchToken();
        $this->assertGreaterThanOrEqual(1, $callCount);

        $cache->invalidate();

        $second = $cache->fetchToken();
        $this->assertGreaterThanOrEqual(2, $callCount);
        $this->assertNotSame($first->token, $second->token);
    }

    public function testNoExpiryTokenIsCachedIndefinitely(): void
    {
        $callCount = 0;
        $inner = new class($callCount) implements AccessTokenProvider {
            public function __construct(private int &$callCount) {}

            public function fetchToken(): AccessToken
            {
                ++$this->callCount;

                return new AccessToken('tok_forever');
            }
        };

        $cache = new TokenCache($inner);
        $cache->fetchToken();
        $cache->fetchToken();
        $cache->fetchToken();

        $this->assertSame(1, $callCount);
    }
}
