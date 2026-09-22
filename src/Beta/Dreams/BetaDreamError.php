<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Failure detail for a Dream whose `status` is `failed`.
 *
 * @phpstan-type BetaDreamErrorShape = array{message: string, type: string}
 */
final class BetaDreamError implements BaseModel
{
    /** @use SdkModel<BetaDreamErrorShape> */
    use SdkModel;

    /**
     * A human-readable explanation of why the dream failed.
     */
    #[Required]
    public string $message;

    /**
     * A code for why the dream failed, such as `timeout` or `internal_error`.
     *
     * The [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#errors) lists common error codes and when they occur.
     */
    #[Required]
    public string $type;

    /**
     * `new BetaDreamError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDreamError::with(message: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDreamError)->withMessage(...)->withType(...)
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
    public static function with(string $message, string $type): self
    {
        $self = new self;

        $self['message'] = $message;
        $self['type'] = $type;

        return $self;
    }

    /**
     * A human-readable explanation of why the dream failed.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * A code for why the dream failed, such as `timeout` or `internal_error`.
     *
     * The [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#errors) lists common error codes and when they occur.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
