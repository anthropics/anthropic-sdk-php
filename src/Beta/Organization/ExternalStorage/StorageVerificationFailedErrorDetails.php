<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The External Storage failed verification, so the request changed nothing. `failed_checks` lists what to fix.
 *
 * @phpstan-import-type ExternalStorageFailedCheckShape from \Anthropic\Beta\Organization\ExternalStorage\ExternalStorageFailedCheck
 *
 * @phpstan-type StorageVerificationFailedErrorDetailsShape = array{
 *   errorCode: 'storage_verification_failed',
 *   failedChecks: list<ExternalStorageFailedCheck|ExternalStorageFailedCheckShape>,
 *   field?: string|null,
 * }
 */
final class StorageVerificationFailedErrorDetails implements BaseModel
{
    /** @use SdkModel<StorageVerificationFailedErrorDetailsShape> */
    use SdkModel;

    /** @var 'storage_verification_failed' $errorCode */
    #[Required('error_code', type: new ConstantOf('storage_verification_failed'))]
    public string $errorCode = 'storage_verification_failed';

    /**
     * One entry for each check that failed.
     *
     * @var list<ExternalStorageFailedCheck> $failedChecks
     */
    #[Required('failed_checks', list: ExternalStorageFailedCheck::class)]
    public array $failedChecks;

    /**
     * The request field at fault. Sent when the refused request is a Workspace's create or update.
     */
    #[Optional(nullable: true)]
    public ?string $field;

    /**
     * `new StorageVerificationFailedErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StorageVerificationFailedErrorDetails::with(failedChecks: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StorageVerificationFailedErrorDetails())->withFailedChecks(...)
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
     * @param list<ExternalStorageFailedCheck|ExternalStorageFailedCheckShape> $failedChecks
     */
    public static function with(
        array $failedChecks,
        ?string $field = null
    ): self {
        $self = new self;

        $self['failedChecks'] = $failedChecks;

        null !== $field && $self['field'] = $field;

        return $self;
    }

    /**
     * @param 'storage_verification_failed' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * One entry for each check that failed.
     *
     * @param list<ExternalStorageFailedCheck|ExternalStorageFailedCheckShape> $failedChecks
     */
    public function withFailedChecks(array $failedChecks): self
    {
        $self = clone $this;
        $self['failedChecks'] = $failedChecks;

        return $self;
    }

    /**
     * The request field at fault. Sent when the refused request is a Workspace's create or update.
     */
    public function withField(?string $field): self
    {
        $self = clone $this;
        $self['field'] = $field;

        return $self;
    }
}
