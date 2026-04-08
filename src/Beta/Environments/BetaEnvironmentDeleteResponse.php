<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Response after deleting an environment.
 *
 * @phpstan-type BetaEnvironmentDeleteResponseShape = array{
 *   id: string, type: 'environment_deleted'
 * }
 */
final class BetaEnvironmentDeleteResponse implements BaseModel
{
    /** @use SdkModel<BetaEnvironmentDeleteResponseShape> */
    use SdkModel;

    /**
     * The type of response.
     *
     * @var 'environment_deleted' $type
     */
    #[Required]
    public string $type = 'environment_deleted';

    /**
     * Environment identifier.
     */
    #[Required]
    public string $id;

    /**
     * `new BetaEnvironmentDeleteResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaEnvironmentDeleteResponse::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaEnvironmentDeleteResponse)->withID(...)
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

    /**
     * Environment identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The type of response.
     *
     * @param 'environment_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
