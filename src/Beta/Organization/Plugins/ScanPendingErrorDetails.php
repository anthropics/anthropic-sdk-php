<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The content scan of the version in `plugin_version_id` is still running. Retry once the scan finishes.
 *
 * @phpstan-type ScanPendingErrorDetailsShape = array{
 *   errorCode: 'scan_pending', pluginVersionID: string
 * }
 */
final class ScanPendingErrorDetails implements BaseModel
{
    /** @use SdkModel<ScanPendingErrorDetailsShape> */
    use SdkModel;

    /** @var 'scan_pending' $errorCode */
    #[Required('error_code', type: new ConstantOf('scan_pending'))]
    public string $errorCode = 'scan_pending';

    #[Required('plugin_version_id')]
    public string $pluginVersionID;

    /**
     * `new ScanPendingErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ScanPendingErrorDetails::with(pluginVersionID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ScanPendingErrorDetails())->withPluginVersionID(...)
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
    public static function with(string $pluginVersionID): self
    {
        $self = new self;

        $self['pluginVersionID'] = $pluginVersionID;

        return $self;
    }

    /**
     * @param 'scan_pending' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    public function withPluginVersionID(string $pluginVersionID): self
    {
        $self = clone $this;
        $self['pluginVersionID'] = $pluginVersionID;

        return $self;
    }
}
