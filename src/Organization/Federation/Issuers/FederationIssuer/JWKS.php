<?php

declare(strict_types=1);

namespace Anthropic\Organization\Federation\Issuers\FederationIssuer;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Organization\Federation\Issuers\JWKSDiscovery;
use Anthropic\Organization\Federation\Issuers\JWKSExplicitURL;
use Anthropic\Organization\Federation\Issuers\JWKSInline;

/**
 * How signing keys are obtained for signature verification.
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
}
