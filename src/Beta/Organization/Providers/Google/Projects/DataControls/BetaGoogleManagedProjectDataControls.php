<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A Google Cloud project's encryption key and storage bucket settings for Claude on Google Cloud's Agent Platform. Your organization has one of these objects for each Google Cloud project that it has proved it owns. You can read and update it, but not create or delete it. Keys and buckets are set for each region. A request's region depends on the Google endpoint it is sent to: `us` is the US multi-region endpoint and the regional endpoint of every location whose name starts with `us-`, `eu` is the EU multi-region endpoint and the regional endpoint of every location whose name starts with `europe-`, `sg` is the `asia-southeast1` regional endpoint, and `global` is the global endpoint, wherever Google serves the request. Anthropic may add regions.
 *
 * @phpstan-import-type BetaGoogleManagedProjectCMEKControlShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKControl
 * @phpstan-import-type BetaGoogleManagedProjectStorageControlShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageControl
 * @phpstan-import-type BetaGoogleManagedProjectCMEKControlVariants from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKControl
 * @phpstan-import-type BetaGoogleManagedProjectStorageControlVariants from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageControl
 *
 * @phpstan-type BetaGoogleManagedProjectDataControlsShape = array{
 *   cmek: BetaGoogleManagedProjectCMEKControlShape,
 *   projectNumber: string,
 *   storage: BetaGoogleManagedProjectStorageControlShape,
 *   type: 'google_managed_project_data_controls',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class BetaGoogleManagedProjectDataControls implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectDataControlsShape> */
    use SdkModel;

    /**
     * Object type. Always `google_managed_project_data_controls`.
     *
     * @var 'google_managed_project_data_controls' $type
     */
    #[Required(type: new ConstantOf('google_managed_project_data_controls'))]
    public string $type = 'google_managed_project_data_controls';

    /**
     * The customer-managed encryption key control: the key in your Google Cloud KMS that is set for each region. It covers the project's requests that name no user profile, or a user profile that has no key of its own for the project.
     *
     * @var BetaGoogleManagedProjectCMEKControlVariants $cmek
     */
    #[Required(union: BetaGoogleManagedProjectCMEKControl::class)]
    public BetaGoogleManagedProjectCMEKDisabled|BetaGoogleManagedProjectCMEKEnabled $cmek;

    /**
     * The number of the Google Cloud project that these controls belong to, in decimal.
     */
    #[Required('project_number')]
    public string $projectNumber;

    /**
     * The customer-owned storage control: your Cloud Storage bucket that is set for each region. It covers the project's requests that name no user profile, or a user profile that has no bucket of its own for the project.
     *
     * @var BetaGoogleManagedProjectStorageControlVariants $storage
     */
    #[Required(union: BetaGoogleManagedProjectStorageControl::class)]
    public BetaGoogleManagedProjectStorageDisabled|BetaGoogleManagedProjectStorageEnabled $storage;

    /**
     * When an update last changed a control, or a region's status last changed, in RFC 3339 format. A region that starts or stops reading `suspended`, a change to `last_checked_at` alone, and the removal of a retired entry do not count.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new BetaGoogleManagedProjectDataControls()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectDataControls::with(
     *   cmek: ..., projectNumber: ..., storage: ..., updatedAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectDataControls())
     *   ->withCMEK(...)
     *   ->withProjectNumber(...)
     *   ->withStorage(...)
     *   ->withUpdatedAt(...)
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
     *
     * @param BetaGoogleManagedProjectCMEKControlShape $cmek
     * @param BetaGoogleManagedProjectStorageControlShape $storage
     */
    public static function with(
        BetaGoogleManagedProjectCMEKDisabled|array|BetaGoogleManagedProjectCMEKEnabled $cmek,
        string $projectNumber,
        BetaGoogleManagedProjectStorageDisabled|array|BetaGoogleManagedProjectStorageEnabled $storage,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['cmek'] = $cmek;
        $self['projectNumber'] = $projectNumber;
        $self['storage'] = $storage;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The customer-managed encryption key control: the key in your Google Cloud KMS that is set for each region. It covers the project's requests that name no user profile, or a user profile that has no key of its own for the project.
     *
     * @param BetaGoogleManagedProjectCMEKControlShape $cmek
     */
    public function withCMEK(
        BetaGoogleManagedProjectCMEKDisabled|array|BetaGoogleManagedProjectCMEKEnabled $cmek,
    ): self {
        $self = clone $this;
        $self['cmek'] = $cmek;

        return $self;
    }

    /**
     * The number of the Google Cloud project that these controls belong to, in decimal.
     */
    public function withProjectNumber(string $projectNumber): self
    {
        $self = clone $this;
        $self['projectNumber'] = $projectNumber;

        return $self;
    }

    /**
     * The customer-owned storage control: your Cloud Storage bucket that is set for each region. It covers the project's requests that name no user profile, or a user profile that has no bucket of its own for the project.
     *
     * @param BetaGoogleManagedProjectStorageControlShape $storage
     */
    public function withStorage(
        BetaGoogleManagedProjectStorageDisabled|array|BetaGoogleManagedProjectStorageEnabled $storage,
    ): self {
        $self = clone $this;
        $self['storage'] = $storage;

        return $self;
    }

    /**
     * Object type. Always `google_managed_project_data_controls`.
     *
     * @param 'google_managed_project_data_controls' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When an update last changed a control, or a region's status last changed, in RFC 3339 format. A region that starts or stops reading `suspended`, a change to `last_checked_at` alone, and the removal of a retired entry do not count.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
