<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A user profile's encryption key and storage bucket settings for Claude on Google Cloud's Agent Platform. Every user profile has one of these objects. You can read and update it, but not create or delete it. Keys and buckets are set for each region. A request's region depends on the Google endpoint it is sent to: `us` is the US multi-region endpoint and the regional endpoint of every location whose name starts with `us-`, `eu` is the EU multi-region endpoint and the regional endpoint of every location whose name starts with `europe-`, `sg` is the `asia-southeast1` regional endpoint, and `global` is the global endpoint, wherever Google serves the request. Anthropic may add regions.
 *
 * @phpstan-import-type BetaGoogleManagedCMEKControlShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKControl
 * @phpstan-import-type BetaGoogleManagedStorageControlShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageControl
 * @phpstan-import-type BetaGoogleManagedCMEKControlVariants from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKControl
 * @phpstan-import-type BetaGoogleManagedStorageControlVariants from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageControl
 *
 * @phpstan-type BetaGoogleManagedDataControlsShape = array{
 *   bucketLabelValue: string,
 *   cmek: BetaGoogleManagedCMEKControlShape,
 *   storage: BetaGoogleManagedStorageControlShape,
 *   type: 'google_managed_data_controls',
 *   updatedAt: \DateTimeInterface,
 *   userProfileID: string,
 * }
 */
final class BetaGoogleManagedDataControls implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedDataControlsShape> */
    use SdkModel;

    /**
     * Object type. Always `google_managed_data_controls`.
     *
     * @var 'google_managed_data_controls' $type
     */
    #[Required(type: new ConstantOf('google_managed_data_controls'))]
    public string $type = 'google_managed_data_controls';

    /**
     * The label value that every bucket set up for this profile must have. It never changes.
     */
    #[Required('bucket_label_value')]
    public string $bucketLabelValue;

    /**
     * The customer-managed encryption key control: the key in the end customer's Google Cloud KMS that is set for each region.
     *
     * @var BetaGoogleManagedCMEKControlVariants $cmek
     */
    #[Required(union: BetaGoogleManagedCMEKControl::class)]
    public BetaGoogleManagedCMEKDisabled|BetaGoogleManagedCMEKEnabled $cmek;

    /**
     * The customer-owned storage control: the end customer's Cloud Storage bucket that is set for each region.
     *
     * @var BetaGoogleManagedStorageControlVariants $storage
     */
    #[Required(union: BetaGoogleManagedStorageControl::class)]
    public BetaGoogleManagedStorageDisabled|BetaGoogleManagedStorageEnabled $storage;

    /**
     * When an update last changed a control, or a region's status last changed, in RFC 3339 format. A region that starts or stops reading `suspended`, a change to `last_checked_at` alone, and the removal of a retired entry do not count.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * The ID of the user profile that these controls belong to (`uprof_...`).
     */
    #[Required('user_profile_id')]
    public string $userProfileID;

    /**
     * `new BetaGoogleManagedDataControls()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedDataControls::with(
     *   bucketLabelValue: ...,
     *   cmek: ...,
     *   storage: ...,
     *   updatedAt: ...,
     *   userProfileID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedDataControls())
     *   ->withBucketLabelValue(...)
     *   ->withCMEK(...)
     *   ->withStorage(...)
     *   ->withUpdatedAt(...)
     *   ->withUserProfileID(...)
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
     * @param BetaGoogleManagedCMEKControlShape $cmek
     * @param BetaGoogleManagedStorageControlShape $storage
     */
    public static function with(
        string $bucketLabelValue,
        BetaGoogleManagedCMEKDisabled|array|BetaGoogleManagedCMEKEnabled $cmek,
        BetaGoogleManagedStorageDisabled|array|BetaGoogleManagedStorageEnabled $storage,
        \DateTimeInterface $updatedAt,
        string $userProfileID,
    ): self {
        $self = new self;

        $self['bucketLabelValue'] = $bucketLabelValue;
        $self['cmek'] = $cmek;
        $self['storage'] = $storage;
        $self['updatedAt'] = $updatedAt;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }

    /**
     * The label value that every bucket set up for this profile must have. It never changes.
     */
    public function withBucketLabelValue(string $bucketLabelValue): self
    {
        $self = clone $this;
        $self['bucketLabelValue'] = $bucketLabelValue;

        return $self;
    }

    /**
     * The customer-managed encryption key control: the key in the end customer's Google Cloud KMS that is set for each region.
     *
     * @param BetaGoogleManagedCMEKControlShape $cmek
     */
    public function withCMEK(
        BetaGoogleManagedCMEKDisabled|array|BetaGoogleManagedCMEKEnabled $cmek
    ): self {
        $self = clone $this;
        $self['cmek'] = $cmek;

        return $self;
    }

    /**
     * The customer-owned storage control: the end customer's Cloud Storage bucket that is set for each region.
     *
     * @param BetaGoogleManagedStorageControlShape $storage
     */
    public function withStorage(
        BetaGoogleManagedStorageDisabled|array|BetaGoogleManagedStorageEnabled $storage,
    ): self {
        $self = clone $this;
        $self['storage'] = $storage;

        return $self;
    }

    /**
     * Object type. Always `google_managed_data_controls`.
     *
     * @param 'google_managed_data_controls' $type
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

    /**
     * The ID of the user profile that these controls belong to (`uprof_...`).
     */
    public function withUserProfileID(string $userProfileID): self
    {
        $self = clone $this;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }
}
