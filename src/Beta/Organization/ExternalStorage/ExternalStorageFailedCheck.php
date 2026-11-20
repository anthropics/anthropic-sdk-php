<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageFailedCheck\Check;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageFailedCheck\Role;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * One check that an External Storage's verification failed.
 *
 * @phpstan-type ExternalStorageFailedCheckShape = array{
 *   check: Check|value-of<Check>, message: string, role: null|Role|value-of<Role>
 * }
 */
final class ExternalStorageFailedCheck implements BaseModel
{
    /** @use SdkModel<ExternalStorageFailedCheckShape> */
    use SdkModel;

    /**
     * Name of the check that failed, such as `versioning`, for code to branch on. New names may be added; `other` is a check this API does not name. The value is a name with no data of its own.
     *
     * @var value-of<Check> $check
     */
    #[Required(enum: Check::class)]
    public string $check;

    /**
     * What failed and how to fix it, in plain words.
     */
    #[Required]
    public string $message;

    /**
     * The part of your access grant that the check is about, such as `ingest`: on AWS, one of the IAM roles your setup created; on Google Cloud, the grant to one of Anthropic's service accounts. `null` when the check is not about one. New names may be added. The value is a name with no data of its own.
     *
     * @var value-of<Role>|null $role
     */
    #[Required(enum: Role::class)]
    public ?string $role;

    /**
     * `new ExternalStorageFailedCheck()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExternalStorageFailedCheck::with(check: ..., message: ..., role: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExternalStorageFailedCheck())
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
     * Name of the check that failed, such as `versioning`, for code to branch on. New names may be added; `other` is a check this API does not name. The value is a name with no data of its own.
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
     * What failed and how to fix it, in plain words.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * The part of your access grant that the check is about, such as `ingest`: on AWS, one of the IAM roles your setup created; on Google Cloud, the grant to one of Anthropic's service accounts. `null` when the check is not about one. New names may be added. The value is a name with no data of its own.
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
