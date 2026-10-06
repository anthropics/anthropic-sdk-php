<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type PluginMarketplaceValidationPluginErrorShape = array{
 *   error: string, errorCode: string, name: string
 * }
 */
final class PluginMarketplaceValidationPluginError implements BaseModel
{
    /** @use SdkModel<PluginMarketplaceValidationPluginErrorShape> */
    use SdkModel;

    /**
     * Why the plugin would be skipped by a synchronization.
     */
    #[Required]
    public string $error;

    /**
     * A stable identifier for the reason — the value to branch on.
     */
    #[Required('error_code')]
    public string $errorCode;

    /**
     * The plugin's name, as its entry in marketplace.json declares it.
     */
    #[Required]
    public string $name;

    /**
     * `new PluginMarketplaceValidationPluginError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginMarketplaceValidationPluginError::with(
     *   error: ..., errorCode: ..., name: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginMarketplaceValidationPluginError())
     *   ->withError(...)
     *   ->withErrorCode(...)
     *   ->withName(...)
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
        string $error,
        string $errorCode,
        string $name
    ): self {
        $self = new self;

        $self['error'] = $error;
        $self['errorCode'] = $errorCode;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Why the plugin would be skipped by a synchronization.
     */
    public function withError(string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * A stable identifier for the reason — the value to branch on.
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * The plugin's name, as its entry in marketplace.json declares it.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
