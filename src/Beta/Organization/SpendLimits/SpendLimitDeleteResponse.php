<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type SpendLimitDeleteResponseShape = array{
 *   id: string, type: 'spend_limit_deleted'
 * }
 */
final class SpendLimitDeleteResponse implements BaseModel
{
    /** @use SdkModel<SpendLimitDeleteResponseShape> */
    use SdkModel;

    /** @var 'spend_limit_deleted' $type */
    #[Required(type: new ConstantOf('spend_limit_deleted'))]
    public string $type = 'spend_limit_deleted';

    #[Required]
    public string $id;

    /**
     * `new SpendLimitDeleteResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitDeleteResponse::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitDeleteResponse())->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'spend_limit_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
