<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageFailedCheck\Check;
use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageFailedCheck\Role;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * One check that a verification attempt failed.
 *
 * @phpstan-type BetaGoogleManagedStorageFailedCheckShape = array{
 *   check: Check|value-of<Check>, message: string, role: null|Role|value-of<Role>
 * }
 */
final class BetaGoogleManagedStorageFailedCheck implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedStorageFailedCheckShape> */
    use SdkModel;

    /**
     * Which check failed, such as `label_mismatch` or `grant_mismatch`. Anthropic may add values.
     *
     * @var value-of<Check> $check
     */
    #[Required(enum: Check::class)]
    public string $check;

    /**
     * What failed and, where the end customer can fix it, what to change.
     */
    #[Required]
    public string $message;

    /**
     * On a check about one of the accounts that Anthropic uses to reach the bucket, that account's kind of access, such as `ingest`. `null` on any other check. Anthropic may add values.
     *
     * @var value-of<Role>|null $role
     */
    #[Required(enum: Role::class)]
    public ?string $role;

    /**
     * `new BetaGoogleManagedStorageFailedCheck()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedStorageFailedCheck::with(check: ..., message: ..., role: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedStorageFailedCheck())
     *   ->withCheck(...)
     *   ->withMessage(...)
     *   ->withRole(...)
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
     * @param Check|value-of<Check> $check
     * @param Role|value-of<Role>|null $role
     */
    public static function with(
        Check|string $check,
        string $message,
        Role|string|null $role
    ): self {
        $self = new self;

        $self['check'] = $check;
        $self['message'] = $message;
        $self['role'] = $role;

        return $self;
    }

    /**
     * Which check failed, such as `label_mismatch` or `grant_mismatch`. Anthropic may add values.
     *
     * @param Check|value-of<Check> $check
     */
    public function withCheck(Check|string $check): self
    {
        $self = clone $this;
        $self['check'] = $check;

        return $self;
    }

    /**
     * What failed and, where the end customer can fix it, what to change.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * On a check about one of the accounts that Anthropic uses to reach the bucket, that account's kind of access, such as `ingest`. `null` on any other check. Anthropic may add values.
     *
     * @param Role|value-of<Role>|null $role
     */
    public function withRole(Role|string|null $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }
}
