<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The version in `plugin_version_id` did not pass its content scan, so it cannot be served.
 *
 * @phpstan-type ScanFailedErrorDetailsShape = array{
 *   errorCode: 'scan_failed', pluginVersionID: string
 * }
 */
final class ScanFailedErrorDetails implements BaseModel
{
    /** @use SdkModel<ScanFailedErrorDetailsShape> */
    use SdkModel;

    /** @var 'scan_failed' $errorCode */
    #[Required('error_code', type: new ConstantOf('scan_failed'))]
    public string $errorCode = 'scan_failed';

    #[Required('plugin_version_id')]
    public string $pluginVersionID;

    /**
     * `new ScanFailedErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ScanFailedErrorDetails::with(pluginVersionID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ScanFailedErrorDetails())->withPluginVersionID(...)
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
     * @param 'scan_failed' $errorCode
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
