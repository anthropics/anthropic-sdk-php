<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams;

use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSDiscovery;
use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSExplicitURL;
use Anthropic\Beta\Organization\Federation\Issuers\BetaJWKSInline;
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
}
