<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Turn a control on or off, or change the key or bucket set for a region. Controls and regions that you leave out stay as they are.
 *
 * Your organization must have proved that it owns the project. Only one organization at a time can have controls turned on for a project.
 *
 * **Requires a credential that identifies a user or a service account**: an OAuth access token with the `org:admin` scope, or an organization-scoped API key that belongs to a user or service account whose organization role can update these controls. The `admin`, `owner` and `primary_owner` roles can. An Admin API key gets a `403` error.
 *
 * @see Anthropic\Services\Beta\Organization\Providers\Google\Projects\DataControlsService::update()
 *
 * @phpstan-import-type BetaGoogleManagedProjectCMEKControlParamsShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKControlParams
 * @phpstan-import-type BetaGoogleManagedProjectStorageControlParamsShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageControlParams
 * @phpstan-import-type BetaGoogleManagedProjectCMEKControlParamsVariants from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKControlParams
 * @phpstan-import-type BetaGoogleManagedProjectStorageControlParamsVariants from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageControlParams
 *
 * @phpstan-type DataControlUpdateParamsShape = array{
 *   cmek?: BetaGoogleManagedProjectCMEKControlParamsShape|null,
 *   storage?: BetaGoogleManagedProjectStorageControlParamsShape|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class DataControlUpdateParams implements BaseModel
{
    /** @use SdkModel<DataControlUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The customer-managed encryption key control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     *
     * @var BetaGoogleManagedProjectCMEKControlParamsVariants|null $cmek
     */
    #[Optional(union: BetaGoogleManagedProjectCMEKControlParams::class)]
    public BetaGoogleManagedProjectCMEKDisabledParams|BetaGoogleManagedProjectCMEKEnabledParams|null $cmek;

    /**
     * The customer-owned storage control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     *
     * @var BetaGoogleManagedProjectStorageControlParamsVariants|null $storage
     */
    #[Optional(union: BetaGoogleManagedProjectStorageControlParams::class)]
    public BetaGoogleManagedProjectStorageDisabledParams|BetaGoogleManagedProjectStorageEnabledParams|null $storage;

    /**
     * This endpoint is in beta: requests must send `google-managed-data-controls-2026-09-01` in this header.
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
     * @param BetaGoogleManagedProjectCMEKControlParamsShape|null $cmek
     * @param BetaGoogleManagedProjectStorageControlParamsShape|null $storage
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        BetaGoogleManagedProjectCMEKDisabledParams|array|BetaGoogleManagedProjectCMEKEnabledParams|null $cmek = null,
        BetaGoogleManagedProjectStorageDisabledParams|array|BetaGoogleManagedProjectStorageEnabledParams|null $storage = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $cmek && $self['cmek'] = $cmek;
        null !== $storage && $self['storage'] = $storage;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The customer-managed encryption key control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     *
     * @param BetaGoogleManagedProjectCMEKControlParamsShape $cmek
     */
    public function withCMEK(
        BetaGoogleManagedProjectCMEKDisabledParams|array|BetaGoogleManagedProjectCMEKEnabledParams $cmek,
    ): self {
        $self = clone $this;
        $self['cmek'] = $cmek;

        return $self;
    }

    /**
     * The customer-owned storage control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     *
     * @param BetaGoogleManagedProjectStorageControlParamsShape $storage
     */
    public function withStorage(
        BetaGoogleManagedProjectStorageDisabledParams|array|BetaGoogleManagedProjectStorageEnabledParams $storage,
    ): self {
        $self = clone $this;
        $self['storage'] = $storage;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `google-managed-data-controls-2026-09-01` in this header.
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
