<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ExternalKeyDeleteResponseShape = array{
 *   id: string, type: 'external_key_deleted'
 * }
 */
final class ExternalKeyDeleteResponse implements BaseModel
{
    /** @use SdkModel<ExternalKeyDeleteResponseShape> */
    use SdkModel;

    /** @var 'external_key_deleted' $type */
    #[Required]
    public string $type = 'external_key_deleted';

    /**
     * ID of the deleted External Key.
     */
    #[Required]
    public string $id;

    /**
     * `new ExternalKeyDeleteResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExternalKeyDeleteResponse::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExternalKeyDeleteResponse)->withID(...)
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
     * ID of the deleted External Key.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'external_key_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
