<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Rules;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Bind to a fixed service account by ID.
 *
 * @phpstan-type BetaServiceAccountTargetShape = array{
 *   serviceAccountID: string,
 *   type: 'service_account',
 *   serviceAccountName?: string|null,
 * }
 */
final class BetaServiceAccountTarget implements BaseModel
{
    /** @use SdkModel<BetaServiceAccountTargetShape> */
    use SdkModel;

    /** @var 'service_account' $type */
    #[Required]
    public string $type = 'service_account';

    /**
     * Tagged ID of the service account to mint tokens for.
     */
    #[Required('service_account_id')]
    public string $serviceAccountID;

    /**
     * Service account's display name at read time. Ignored on writes.
     */
    #[Optional('service_account_name', nullable: true)]
    public ?string $serviceAccountName;

    /**
     * `new BetaServiceAccountTarget()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaServiceAccountTarget::with(serviceAccountID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaServiceAccountTarget)->withServiceAccountID(...)
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
    public static function with(
        string $serviceAccountID,
        ?string $serviceAccountName = null
    ): self {
        $self = new self;

        $self['serviceAccountID'] = $serviceAccountID;

        null !== $serviceAccountName && $self['serviceAccountName'] = $serviceAccountName;

        return $self;
    }

    /**
     * Tagged ID of the service account to mint tokens for.
     */
    public function withServiceAccountID(string $serviceAccountID): self
    {
        $self = clone $this;
        $self['serviceAccountID'] = $serviceAccountID;

        return $self;
    }

    /**
     * @param 'service_account' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Service account's display name at read time. Ignored on writes.
     */
    public function withServiceAccountName(?string $serviceAccountName): self
    {
        $self = clone $this;
        $self['serviceAccountName'] = $serviceAccountName;

        return $self;
    }
}
