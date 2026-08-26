<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys;

use Anthropic\Beta\Organization\APIKeys\APIKeyListParams\Status;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List API Keys.
 *
 * @see Anthropic\Services\Beta\Organization\APIKeysService::list()
 *
 * @phpstan-type APIKeyListParamsShape = array{
 *   afterID?: string|null,
 *   beforeID?: string|null,
 *   createdByUserID?: string|null,
 *   limit?: int|null,
 *   status?: null|Status|value-of<Status>,
 *   workspaceID?: string|null,
 * }
 */
final class APIKeyListParams implements BaseModel
{
    /** @use SdkModel<APIKeyListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    #[Optional]
    public ?string $afterID;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    #[Optional]
    public ?string $beforeID;

    /**
     * Filter by the ID of the User who created the object.
     */
    #[Optional(nullable: true)]
    public ?string $createdByUserID;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Filter by API key status.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class, nullable: true)]
    public ?string $status;

    /**
     * Filter by Workspace ID.
     */
    #[Optional(nullable: true)]
    public ?string $workspaceID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?string $createdByUserID = null,
        ?int $limit = null,
        Status|string|null $status = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $afterID && $self['afterID'] = $afterID;
        null !== $beforeID && $self['beforeID'] = $beforeID;
        null !== $createdByUserID && $self['createdByUserID'] = $createdByUserID;
        null !== $limit && $self['limit'] = $limit;
        null !== $status && $self['status'] = $status;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    public function withAfterID(string $afterID): self
    {
        $self = clone $this;
        $self['afterID'] = $afterID;

        return $self;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     */
    public function withBeforeID(string $beforeID): self
    {
        $self = clone $this;
        $self['beforeID'] = $beforeID;

        return $self;
    }

    /**
     * Filter by the ID of the User who created the object.
     */
    public function withCreatedByUserID(?string $createdByUserID): self
    {
        $self = clone $this;
        $self['createdByUserID'] = $createdByUserID;

        return $self;
    }

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Filter by API key status.
     *
     * @param Status|value-of<Status>|null $status
     */
    public function withStatus(Status|string|null $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Filter by Workspace ID.
     */
    public function withWorkspaceID(?string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
