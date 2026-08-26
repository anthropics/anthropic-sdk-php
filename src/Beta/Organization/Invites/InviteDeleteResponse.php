<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Invites;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type InviteDeleteResponseShape = array{
 *   id: string, type: 'invite_deleted'
 * }
 */
final class InviteDeleteResponse implements BaseModel
{
    /** @use SdkModel<InviteDeleteResponseShape> */
    use SdkModel;

    /**
     * Deleted object type.
     *
     * For Invites, this is always `"invite_deleted"`.
     *
     * @var 'invite_deleted' $type
     */
    #[Required]
    public string $type = 'invite_deleted';

    /**
     * ID of the Invite.
     */
    #[Required]
    public string $id;

    /**
     * `new InviteDeleteResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InviteDeleteResponse::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InviteDeleteResponse)->withID(...)
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
     * ID of the Invite.
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
     * For Invites, this is always `"invite_deleted"`.
     *
     * @param 'invite_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
