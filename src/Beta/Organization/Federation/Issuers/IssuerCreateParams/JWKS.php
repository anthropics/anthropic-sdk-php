<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams;

use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSDiscovery;
use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSExplicitURL;
use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSInline;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams\JWKS\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * How signing keys are obtained. Defaults to OIDC discovery.
 *
 * @phpstan-import-type BetaJWKSDiscoveryShape from \Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSDiscovery
 * @phpstan-import-type BetaJWKSExplicitURLShape from \Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSExplicitURL
 * @phpstan-import-type BetaJWKSInlineShape from \Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSInline
 *
 * @phpstan-type JWKSVariants = BetaJWKSDiscovery|BetaJWKSExplicitURL|BetaJWKSInline
 * @phpstan-type JWKSShape = JWKSVariants|BetaJWKSDiscoveryShape|BetaJWKSExplicitURLShape|BetaJWKSInlineShape
 */
final class JWKS implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'discovery' => BetaJWKSDiscovery::class,
            'explicit_url' => BetaJWKSExplicitURL::class,
            'inline' => BetaJWKSInline::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<array<string,mixed>>|null $keys
     *
     * @return ($type is Type::DISCOVERY|'discovery' ? BetaJWKSDiscovery : ($type is Type::EXPLICIT_URL|'explicit_url' ? BetaJWKSExplicitURL : ($type is Type::INLINE|'inline' ? BetaJWKSInline : BetaJWKSDiscovery|BetaJWKSExplicitURL|BetaJWKSInline)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $caCertPEM = null,
        ?string $discoveryBase = null,
        ?string $url = null,
        ?array $keys = null,
    ): BetaJWKSDiscovery|BetaJWKSExplicitURL|BetaJWKSInline {
        return match ($type) {
            Type::DISCOVERY, 'discovery' => BetaJWKSDiscovery::with(
                caCertPEM: $caCertPEM,
                discoveryBase: $discoveryBase
            ),
            Type::EXPLICIT_URL, 'explicit_url' => BetaJWKSExplicitURL::with(
                url: $url ?? throw new \ArgumentCountError('$url is required'),
                caCertPEM: $caCertPEM,
            ),
            Type::INLINE, 'inline' => BetaJWKSInline::with(
                keys: $keys ?? throw new \ArgumentCountError('$keys is required')
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
