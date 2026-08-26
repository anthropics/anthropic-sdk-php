<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type UserRemoveResponseShape = array{id: string, type: 'user_deleted'}
 */
final class UserRemoveResponse implements BaseModel
{
    /** @use SdkModel<UserRemoveResponseShape> */
    use SdkModel;

    /**
     * Deleted object type.
     *
     * For Users, this is always `"user_deleted"`.
     *
     * @var 'user_deleted' $type
     */
    #[Required]
    public string $type = 'user_deleted';

    /**
     * ID of the User.
     */
    #[Required]
    public string $id;

    /**
     * `new UserRemoveResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserRemoveResponse::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserRemoveResponse)->withID(...)
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
     * ID of the User.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Deleted object type.
     *
     * For Users, this is always `"user_deleted"`.
     *
     * @param 'user_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
