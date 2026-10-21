<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Session creation was rejected due to rate limiting. The schedule keeps firing; subsequent runs may succeed.
 *
 * @phpstan-type BetaManagedAgentsSessionRateLimitedRunErrorShape = array{
 *   message: string, type: 'session_rate_limited_error'
 * }
 */
final class BetaManagedAgentsSessionRateLimitedRunError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionRateLimitedRunErrorShape> */
    use SdkModel;

    /** @var 'session_rate_limited_error' $type */
    #[Required(type: new ConstantOf('session_rate_limited_error'))]
    public string $type = 'session_rate_limited_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsSessionRateLimitedRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionRateLimitedRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionRateLimitedRunError())->withMessage(...)
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
    public static function with(string $message): self
    {
        $self = new self;

        $self['message'] = $message;

        return $self;
    }

    /**
     * Human-readable error description.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * @param 'session_rate_limited_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
