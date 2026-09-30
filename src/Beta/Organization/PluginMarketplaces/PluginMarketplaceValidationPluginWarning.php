<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type PluginMarketplaceValidationPluginWarningShape = array{
 *   errorCode: string, message: string
 * }
 */
final class PluginMarketplaceValidationPluginWarning implements BaseModel
{
    /** @use SdkModel<PluginMarketplaceValidationPluginWarningShape> */
    use SdkModel;

    /**
     * A stable identifier for the kind of warning.
     */
    #[Required('error_code')]
    public string $errorCode;

    /**
     * What would be left out, and why.
     */
    #[Required]
    public string $message;

    /**
     * `new PluginMarketplaceValidationPluginWarning()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginMarketplaceValidationPluginWarning::with(errorCode: ..., message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginMarketplaceValidationPluginWarning)
     *   ->withErrorCode(...)
     *   ->withMessage(...)
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
    public static function with(string $errorCode, string $message): self
    {
        $self = new self;

        $self['errorCode'] = $errorCode;
        $self['message'] = $message;

        return $self;
    }

    /**
     * A stable identifier for the kind of warning.
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * What would be left out, and why.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
