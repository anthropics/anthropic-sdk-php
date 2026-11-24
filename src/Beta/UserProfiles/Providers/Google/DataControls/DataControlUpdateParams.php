<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Turn a control on or off, or change the key or bucket set for a region. Controls and regions that you leave out stay as they are.
 *
 * @see Anthropic\Services\Beta\UserProfiles\Providers\Google\DataControlsService::update()
 *
 * @phpstan-import-type BetaGoogleManagedCMEKControlParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKControlParams
 * @phpstan-import-type BetaGoogleManagedStorageControlParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageControlParams
 * @phpstan-import-type BetaGoogleManagedCMEKControlParamsVariants from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKControlParams
 * @phpstan-import-type BetaGoogleManagedStorageControlParamsVariants from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageControlParams
 *
 * @phpstan-type DataControlUpdateParamsShape = array{
 *   cmek?: BetaGoogleManagedCMEKControlParamsShape|null,
 *   storage?: BetaGoogleManagedStorageControlParamsShape|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
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
     * @var BetaGoogleManagedCMEKControlParamsVariants|null $cmek
     */
    #[Optional(union: BetaGoogleManagedCMEKControlParams::class)]
    public BetaGoogleManagedCMEKDisabledParams|BetaGoogleManagedCMEKEnabledParams|null $cmek;

    /**
     * The customer-owned storage control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     *
     * @var BetaGoogleManagedStorageControlParamsVariants|null $storage
     */
    #[Optional(union: BetaGoogleManagedStorageControlParams::class)]
    public BetaGoogleManagedStorageDisabledParams|BetaGoogleManagedStorageEnabledParams|null $storage;

    /**
     * This endpoint is in beta: requests must send `google-managed-data-controls-2026-09-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    #[Optional]
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
     * @param BetaGoogleManagedCMEKControlParamsShape|null $cmek
     * @param BetaGoogleManagedStorageControlParamsShape|null $storage
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        BetaGoogleManagedCMEKDisabledParams|array|BetaGoogleManagedCMEKEnabledParams|null $cmek = null,
        BetaGoogleManagedStorageDisabledParams|array|BetaGoogleManagedStorageEnabledParams|null $storage = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $cmek && $self['cmek'] = $cmek;
        null !== $storage && $self['storage'] = $storage;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The customer-managed encryption key control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     *
     * @param BetaGoogleManagedCMEKControlParamsShape $cmek
     */
    public function withCMEK(
        BetaGoogleManagedCMEKDisabledParams|array|BetaGoogleManagedCMEKEnabledParams $cmek,
    ): self {
        $self = clone $this;
        $self['cmek'] = $cmek;

        return $self;
    }

    /**
     * The customer-owned storage control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
     *
     * @param BetaGoogleManagedStorageControlParamsShape $storage
     */
    public function withStorage(
        BetaGoogleManagedStorageDisabledParams|array|BetaGoogleManagedStorageEnabledParams $storage,
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

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
