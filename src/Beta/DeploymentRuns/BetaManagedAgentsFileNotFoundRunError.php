<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A file resource referenced by the deployment no longer exists.
 *
 * @phpstan-type BetaManagedAgentsFileNotFoundRunErrorShape = array{
 *   message: string, type: 'file_not_found_error'
 * }
 */
final class BetaManagedAgentsFileNotFoundRunError implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsFileNotFoundRunErrorShape> */
    use SdkModel;

    /** @var 'file_not_found_error' $type */
    #[Required(type: new ConstantOf('file_not_found_error'))]
    public string $type = 'file_not_found_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * `new BetaManagedAgentsFileNotFoundRunError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsFileNotFoundRunError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsFileNotFoundRunError())->withMessage(...)
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
     * @param 'file_not_found_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
