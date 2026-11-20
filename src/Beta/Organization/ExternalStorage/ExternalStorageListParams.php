<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the organization's External Storage, newest first.
 *
 * @see Anthropic\Services\Beta\Organization\ExternalStorageService::list()
 *
 * @phpstan-type ExternalStorageListParamsShape = array{
 *   limit?: int|null,
 *   page?: string|null,
 *   userProfileIDs?: list<string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class ExternalStorageListParams implements BaseModel
{
    /** @use SdkModel<ExternalStorageListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of results per page.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * Returns only External Storage bound to one of these user profile IDs (`uprof_...`). An empty entry matches storage bound to no user profile. At most 10 entries, counting repeats.
     *
     * @var list<string>|null $userProfileIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $userProfileIDs;

    /**
     * This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $userProfileIDs
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?int $limit = null,
        ?string $page = null,
        ?array $userProfileIDs = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $userProfileIDs && $self['userProfileIDs'] = $userProfileIDs;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Number of results per page.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Returns only External Storage bound to one of these user profile IDs (`uprof_...`). An empty entry matches storage bound to no user profile. At most 10 entries, counting repeats.
     *
     * @param list<string>|null $userProfileIDs
     */
    public function withUserProfileIDs(?array $userProfileIDs): self
    {
        $self = clone $this;
        $self['userProfileIDs'] = $userProfileIDs;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `efs-2026-10-01` in this header.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
