<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Read one message that Anthropic flagged for your organization to review, with its request and response.
 *
 * A message that the API key can't read, or that isn't flagged, returns the same 404 as one that doesn't exist. For a message recorded with a user profile, send that profile's ID in the `anthropic-user-profile-id` header. A flagged message can also return 404 if it belongs to another organization than the key's own, or to your end customer's user profile or Workspace.
 *
 * If your encryption key or storage bucket refuses the read, the API returns a 400 with `cmek_key_disabled`, `storage_bucket_unreadable` or `customer_storage_refusal_unattributed` in `error.details.error_code`.
 *
 * The API key must have the `read:compliance_review_items`, `read:compliance_user_data` or `read:org_audit` scope. A key of an organization with no parent organization must have `read:compliance_review_items`.
 *
 * @see Anthropic\Services\Beta\Compliance\Review\ItemsService::retrieve()
 *
 * @phpstan-type ItemRetrieveParamsShape = array{
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   userProfileID?: string|null,
 * }
 */
final class ItemRetrieveParams implements BaseModel
{
    /** @use SdkModel<ItemRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * The ID of the user profile that the message was recorded with (`uprof_...`). Send it for a message recorded with a user profile, and leave it out for a message recorded with none.
     */
    #[Optional]
    public ?string $userProfileID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?array $betas = null,
        ?string $userProfileID = null
    ): self {
        $self = new self;

        null !== $betas && $self['betas'] = $betas;
        null !== $userProfileID && $self['userProfileID'] = $userProfileID;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }

    /**
     * The ID of the user profile that the message was recorded with (`uprof_...`). Send it for a message recorded with a user profile, and leave it out for a message recorded with none.
     */
    public function withUserProfileID(string $userProfileID): self
    {
        $self = clone $this;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }
}
