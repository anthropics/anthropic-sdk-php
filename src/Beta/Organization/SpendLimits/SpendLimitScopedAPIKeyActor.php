<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A scoped Admin API key acting on behalf of the organization.
 *
 * @phpstan-type SpendLimitScopedAPIKeyActorShape = array{
 *   scopedAPIKeyID: string, type: 'scoped_api_key_actor'
 * }
 */
final class SpendLimitScopedAPIKeyActor implements BaseModel
{
    /** @use SdkModel<SpendLimitScopedAPIKeyActorShape> */
    use SdkModel;

    /** @var 'scoped_api_key_actor' $type */
    #[Required(type: new ConstantOf('scoped_api_key_actor'))]
    public string $type = 'scoped_api_key_actor';

    #[Required('scoped_api_key_id')]
    public string $scopedAPIKeyID;

    /**
     * `new SpendLimitScopedAPIKeyActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitScopedAPIKeyActor::with(scopedAPIKeyID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitScopedAPIKeyActor)->withScopedAPIKeyID(...)
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
     */
    public static function with(string $scopedAPIKeyID): self
    {
        $self = new self;

        $self['scopedAPIKeyID'] = $scopedAPIKeyID;

        return $self;
    }

    public function withScopedAPIKeyID(string $scopedAPIKeyID): self
    {
        $self = clone $this;
        $self['scopedAPIKeyID'] = $scopedAPIKeyID;

        return $self;
    }

    /**
     * @param 'scoped_api_key_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
