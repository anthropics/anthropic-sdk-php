<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type PluginMarketplaceValidationPluginWarningShape from \Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidationPluginWarning
 *
 * @phpstan-type PluginMarketplaceValidationPluginWarningsShape = array{
 *   name: string,
 *   warnings: list<PluginMarketplaceValidationPluginWarning|PluginMarketplaceValidationPluginWarningShape>,
 * }
 */
final class PluginMarketplaceValidationPluginWarnings implements BaseModel
{
    /** @use SdkModel<PluginMarketplaceValidationPluginWarningsShape> */
    use SdkModel;

    /**
     * The plugin's name, as its entry in marketplace.json declares it.
     */
    #[Required]
    public string $name;

    /**
     * The parts of the plugin a synchronization would leave out.
     *
     * @var list<PluginMarketplaceValidationPluginWarning> $warnings
     */
    #[Required(list: PluginMarketplaceValidationPluginWarning::class)]
    public array $warnings;

    /**
     * `new PluginMarketplaceValidationPluginWarnings()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginMarketplaceValidationPluginWarnings::with(name: ..., warnings: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginMarketplaceValidationPluginWarnings)
     *   ->withName(...)
     *   ->withWarnings(...)
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
     * @param list<PluginMarketplaceValidationPluginWarning|PluginMarketplaceValidationPluginWarningShape> $warnings
     */
    public static function with(string $name, array $warnings): self
    {
        $self = new self;

        $self['name'] = $name;
        $self['warnings'] = $warnings;

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

    /**
     * The parts of the plugin a synchronization would leave out.
     *
     * @param list<PluginMarketplaceValidationPluginWarning|PluginMarketplaceValidationPluginWarningShape> $warnings
     */
    public function withWarnings(array $warnings): self
    {
        $self = clone $this;
        $self['warnings'] = $warnings;

        return $self;
    }
}
