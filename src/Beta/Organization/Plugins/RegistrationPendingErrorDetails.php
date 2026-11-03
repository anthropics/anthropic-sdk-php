<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The Plugin version was stored but is not yet usable in claude.ai. `plugin_id` and `plugin_version_id` identify what was stored.
 *
 * @phpstan-type RegistrationPendingErrorDetailsShape = array{
 *   errorCode: 'registration_pending', pluginID: string, pluginVersionID: string
 * }
 */
final class RegistrationPendingErrorDetails implements BaseModel
{
    /** @use SdkModel<RegistrationPendingErrorDetailsShape> */
    use SdkModel;

    /** @var 'registration_pending' $errorCode */
    #[Required('error_code', type: new ConstantOf('registration_pending'))]
    public string $errorCode = 'registration_pending';

    #[Required('plugin_id')]
    public string $pluginID;

    #[Required('plugin_version_id')]
    public string $pluginVersionID;

    /**
     * `new RegistrationPendingErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RegistrationPendingErrorDetails::with(pluginID: ..., pluginVersionID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RegistrationPendingErrorDetails())
     *   ->withPluginID(...)
     *   ->withPluginVersionID(...)
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
    public static function with(string $pluginID, string $pluginVersionID): self
    {
        $self = new self;

        $self['pluginID'] = $pluginID;
        $self['pluginVersionID'] = $pluginVersionID;

        return $self;
    }

    /**
     * @param 'registration_pending' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    public function withPluginID(string $pluginID): self
    {
        $self = clone $this;
        $self['pluginID'] = $pluginID;

        return $self;
    }

    public function withPluginVersionID(string $pluginVersionID): self
    {
        $self = clone $this;
        $self['pluginVersionID'] = $pluginVersionID;

        return $self;
    }
}
