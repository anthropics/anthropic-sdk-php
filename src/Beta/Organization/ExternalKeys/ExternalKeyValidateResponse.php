<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyValidateResponse\Status;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Result of a validation roundtrip against the customer's KMS.
 *
 * HTTP 200 for both outcomes — the operation completed; `status` says
 * whether the key works.
 *
 * @phpstan-type ExternalKeyValidateResponseShape = array{
 *   error: string|null,
 *   status: Status|value-of<Status>,
 *   type: 'external_key_validation',
 * }
 */
final class ExternalKeyValidateResponse implements BaseModel
{
    /** @use SdkModel<ExternalKeyValidateResponseShape> */
    use SdkModel;

    /** @var 'external_key_validation' $type */
    #[Required]
    public string $type = 'external_key_validation';

    /**
     * Error message when status is `failure`. Null otherwise.
     */
    #[Required]
    public ?string $error;

    /**
     * `success` — encrypt/decrypt roundtrip succeeded. `failure` — the roundtrip failed or timed out; see `error`.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * `new ExternalKeyValidateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExternalKeyValidateResponse::with(error: ..., status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExternalKeyValidateResponse)->withError(...)->withStatus(...)
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
     * @param Status|value-of<Status> $status
     */
    public static function with(?string $error, Status|string $status): self
    {
        $self = new self;

        $self['error'] = $error;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Error message when status is `failure`. Null otherwise.
     */
    public function withError(?string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * `success` — encrypt/decrypt roundtrip succeeded. `failure` — the roundtrip failed or timed out; see `error`.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * @param 'external_key_validation' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
