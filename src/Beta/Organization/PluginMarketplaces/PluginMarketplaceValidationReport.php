<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The outcome of validating plugin marketplace content: a report, not a
 * stored object, so nothing in it can be retrieved afterwards.
 *
 * @phpstan-import-type PluginMarketplaceValidationPluginErrorShape from \Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidationPluginError
 * @phpstan-import-type PluginMarketplaceValidationPluginWarningsShape from \Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidationPluginWarnings
 *
 * @phpstan-type PluginMarketplaceValidationReportShape = array{
 *   commitSha: string|null,
 *   manifestError: string|null,
 *   manifestErrorCode: string|null,
 *   pluginErrors: list<PluginMarketplaceValidationPluginError|PluginMarketplaceValidationPluginErrorShape>,
 *   pluginWarnings: list<PluginMarketplaceValidationPluginWarnings|PluginMarketplaceValidationPluginWarningsShape>,
 *   ref: string|null,
 *   totalPluginCount: int,
 *   type: 'plugin_marketplace_validation_report',
 *   valid: bool,
 * }
 */
final class PluginMarketplaceValidationReport implements BaseModel
{
    /** @use SdkModel<PluginMarketplaceValidationReportShape> */
    use SdkModel;

    /**
     * Always `plugin_marketplace_validation_report`.
     *
     * @var 'plugin_marketplace_validation_report' $type
     */
    #[Required(type: new ConstantOf('plugin_marketplace_validation_report'))]
    public string $type = 'plugin_marketplace_validation_report';

    /**
     * The full SHA of the commit that was validated: for a repository, the commit that was read; for an uploaded archive, the commit recorded in the archive's comment (as a Git host's download writes it; not verified), else null.
     */
    #[Required('commit_sha')]
    public ?string $commitSha;

    /**
     * Set when nothing could be validated: the repository or archive could not be read, or marketplace.json is missing, malformed or over a limit. Null otherwise.
     */
    #[Required('manifest_error')]
    public ?string $manifestError;

    /**
     * A stable identifier for `manifest_error`; null when that is.
     */
    #[Required('manifest_error_code')]
    public ?string $manifestErrorCode;

    /**
     * One entry per plugin a synchronization would skip entirely, keyed by the plugin's name in marketplace.json.
     *
     * @var list<PluginMarketplaceValidationPluginError> $pluginErrors
     */
    #[Required(
        'plugin_errors',
        list: PluginMarketplaceValidationPluginError::class
    )]
    public array $pluginErrors;

    /**
     * One entry per plugin that would synchronize with some of its contents left out, keyed by the plugin's name in marketplace.json.
     *
     * @var list<PluginMarketplaceValidationPluginWarnings> $pluginWarnings
     */
    #[Required(
        'plugin_warnings',
        list: PluginMarketplaceValidationPluginWarnings::class
    )]
    public array $pluginWarnings;

    /**
     * For a repository, the branch that was read by name: the one requested, or else the branch a synchronization of this repository is set to read. Null when no branch is named or set and the repository's default branch was read, for a request by commit SHA, and for an uploaded archive.
     */
    #[Required]
    public ?string $ref;

    /**
     * How many plugins marketplace.json declares; 0 when it could not be read.
     */
    #[Required('total_plugin_count')]
    public int $totalPluginCount;

    /**
     * True when marketplace.json is well-formed and no plugin would be skipped; warnings never make it false.
     */
    #[Required]
    public bool $valid;

    /**
     * `new PluginMarketplaceValidationReport()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginMarketplaceValidationReport::with(
     *   commitSha: ...,
     *   manifestError: ...,
     *   manifestErrorCode: ...,
     *   pluginErrors: ...,
     *   pluginWarnings: ...,
     *   ref: ...,
     *   totalPluginCount: ...,
     *   valid: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginMarketplaceValidationReport())
     *   ->withCommitSha(...)
     *   ->withManifestError(...)
     *   ->withManifestErrorCode(...)
     *   ->withPluginErrors(...)
     *   ->withPluginWarnings(...)
     *   ->withRef(...)
     *   ->withTotalPluginCount(...)
     *   ->withValid(...)
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
     * @param list<PluginMarketplaceValidationPluginError|PluginMarketplaceValidationPluginErrorShape> $pluginErrors
     * @param list<PluginMarketplaceValidationPluginWarnings|PluginMarketplaceValidationPluginWarningsShape> $pluginWarnings
     */
    public static function with(
        ?string $commitSha,
        ?string $manifestError,
        ?string $manifestErrorCode,
        array $pluginErrors,
        array $pluginWarnings,
        ?string $ref,
        int $totalPluginCount,
        bool $valid,
    ): self {
        $self = new self;

        $self['commitSha'] = $commitSha;
        $self['manifestError'] = $manifestError;
        $self['manifestErrorCode'] = $manifestErrorCode;
        $self['pluginErrors'] = $pluginErrors;
        $self['pluginWarnings'] = $pluginWarnings;
        $self['ref'] = $ref;
        $self['totalPluginCount'] = $totalPluginCount;
        $self['valid'] = $valid;

        return $self;
    }

    /**
     * The full SHA of the commit that was validated: for a repository, the commit that was read; for an uploaded archive, the commit recorded in the archive's comment (as a Git host's download writes it; not verified), else null.
     */
    public function withCommitSha(?string $commitSha): self
    {
        $self = clone $this;
        $self['commitSha'] = $commitSha;

        return $self;
    }

    /**
     * Set when nothing could be validated: the repository or archive could not be read, or marketplace.json is missing, malformed or over a limit. Null otherwise.
     */
    public function withManifestError(?string $manifestError): self
    {
        $self = clone $this;
        $self['manifestError'] = $manifestError;

        return $self;
    }

    /**
     * A stable identifier for `manifest_error`; null when that is.
     */
    public function withManifestErrorCode(?string $manifestErrorCode): self
    {
        $self = clone $this;
        $self['manifestErrorCode'] = $manifestErrorCode;

        return $self;
    }

    /**
     * One entry per plugin a synchronization would skip entirely, keyed by the plugin's name in marketplace.json.
     *
     * @param list<PluginMarketplaceValidationPluginError|PluginMarketplaceValidationPluginErrorShape> $pluginErrors
     */
    public function withPluginErrors(array $pluginErrors): self
    {
        $self = clone $this;
        $self['pluginErrors'] = $pluginErrors;

        return $self;
    }

    /**
     * One entry per plugin that would synchronize with some of its contents left out, keyed by the plugin's name in marketplace.json.
     *
     * @param list<PluginMarketplaceValidationPluginWarnings|PluginMarketplaceValidationPluginWarningsShape> $pluginWarnings
     */
    public function withPluginWarnings(array $pluginWarnings): self
    {
        $self = clone $this;
        $self['pluginWarnings'] = $pluginWarnings;

        return $self;
    }

    /**
     * For a repository, the branch that was read by name: the one requested, or else the branch a synchronization of this repository is set to read. Null when no branch is named or set and the repository's default branch was read, for a request by commit SHA, and for an uploaded archive.
     */
    public function withRef(?string $ref): self
    {
        $self = clone $this;
        $self['ref'] = $ref;

        return $self;
    }

    /**
     * How many plugins marketplace.json declares; 0 when it could not be read.
     */
    public function withTotalPluginCount(int $totalPluginCount): self
    {
        $self = clone $this;
        $self['totalPluginCount'] = $totalPluginCount;

        return $self;
    }

    /**
     * Always `plugin_marketplace_validation_report`.
     *
     * @param 'plugin_marketplace_validation_report' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * True when marketplace.json is well-formed and no plugin would be skipped; warnings never make it false.
     */
    public function withValid(bool $valid): self
    {
        $self = clone $this;
        $self['valid'] = $valid;

        return $self;
    }
}
