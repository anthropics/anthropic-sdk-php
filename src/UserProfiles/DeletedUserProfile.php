<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type DeletedUserProfileShape = array{
 *   id: string, type: 'user_profile_deleted'
 * }
 */
final class DeletedUserProfile implements BaseModel
{
    /** @use SdkModel<DeletedUserProfileShape> */
    use SdkModel;

    /**
     * Object type. Always `user_profile_deleted`.
     *
     * @var 'user_profile_deleted' $type
     */
    #[Required(type: new ConstantOf('user_profile_deleted'))]
    public string $type = 'user_profile_deleted';

    /**
     * Identifier of the deleted user profile, prefixed `uprof_`.
     */
    #[Required]
    public string $id;

    /**
     * `new DeletedUserProfile()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeletedUserProfile::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeletedUserProfile())->withID(...)
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
     * Identifier of the deleted user profile, prefixed `uprof_`.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Object type. Always `user_profile_deleted`.
     *
     * @param 'user_profile_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
