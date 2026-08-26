<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Issuers;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * JWKS supplied directly; no network fetch.
 *
 * @phpstan-type BetaJWKSInlineShape = array{
 *   keys: list<array<string,mixed>>, type: 'inline'
 * }
 */
final class BetaJWKSInline implements BaseModel
{
    /** @use SdkModel<BetaJWKSInlineShape> */
    use SdkModel;

    /** @var 'inline' $type */
    #[Required]
    public string $type = 'inline';

    /**
     * Inline JWK objects.
     *
     * @var list<array<string,mixed>> $keys
     */
    #[Required(list: new MapOf('mixed'))]
    public array $keys;

    /**
     * `new BetaJWKSInline()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaJWKSInline::with(keys: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaJWKSInline)->withKeys(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<array<string,mixed>> $keys
     */
    public static function with(array $keys): self
    {
        $self = new self;

        $self['keys'] = $keys;

        return $self;
    }

    /**
     * Inline JWK objects.
     *
     * @param list<array<string,mixed>> $keys
     */
    public function withKeys(array $keys): self
    {
        $self = clone $this;
        $self['keys'] = $keys;

        return $self;
    }

    /**
     * @param 'inline' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
