<?php

declare(strict_types=1);

namespace Anthropic\Organization\Federation\Issuers\IssuerUpdateParams;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Organization\Federation\Issuers\IssuerUpdateParams\JWKS\Type;
use Anthropic\Organization\Federation\Issuers\JWKSDiscovery;
use Anthropic\Organization\Federation\Issuers\JWKSExplicitURL;
use Anthropic\Organization\Federation\Issuers\JWKSInline;

/**
 * Replaces the entire JWKS configuration.
 *
 * @phpstan-import-type JWKSDiscoveryShape from \Anthropic\Organization\Federation\Issuers\JWKSDiscovery
 * @phpstan-import-type JWKSExplicitURLShape from \Anthropic\Organization\Federation\Issuers\JWKSExplicitURL
 * @phpstan-import-type JWKSInlineShape from \Anthropic\Organization\Federation\Issuers\JWKSInline
 *
 * @phpstan-type JWKSVariants = JWKSDiscovery|JWKSExplicitURL|JWKSInline
 * @phpstan-type JWKSShape = JWKSVariants|JWKSDiscoveryShape|JWKSExplicitURLShape|JWKSInlineShape
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
            'discovery' => JWKSDiscovery::class,
            'explicit_url' => JWKSExplicitURL::class,
            'inline' => JWKSInline::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<array<string,mixed>>|null $keys
     *
     * @return ($type is Type::DISCOVERY|'discovery' ? JWKSDiscovery : ($type is Type::EXPLICIT_URL|'explicit_url' ? JWKSExplicitURL : ($type is Type::INLINE|'inline' ? JWKSInline : JWKSDiscovery|JWKSExplicitURL|JWKSInline)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $caCertPEM = null,
        ?string $discoveryBase = null,
        ?string $url = null,
        ?array $keys = null,
    ): JWKSDiscovery|JWKSExplicitURL|JWKSInline {
        return match ($type) {
            Type::DISCOVERY, 'discovery' => JWKSDiscovery::with(
                caCertPEM: $caCertPEM,
                discoveryBase: $discoveryBase
            ),
            Type::EXPLICIT_URL, 'explicit_url' => JWKSExplicitURL::with(
                url: $url ?? throw new \ArgumentCountError('$url is required'),
                caCertPEM: $caCertPEM,
            ),
            Type::INLINE, 'inline' => JWKSInline::with(
                keys: $keys ?? throw new \ArgumentCountError('$keys is required')
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
