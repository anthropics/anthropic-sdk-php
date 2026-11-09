<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The marketplace already holds this name. `plugin_id` is the Plugin that holds it, and can be absent.
 *
 * @phpstan-type PluginNameTakenErrorDetailsShape = array{
 *   errorCode: 'plugin_name_taken', pluginID?: string|null
 * }
 */
final class PluginNameTakenErrorDetails implements BaseModel
{
    /** @use SdkModel<PluginNameTakenErrorDetailsShape> */
    use SdkModel;

    /** @var 'plugin_name_taken' $errorCode */
    #[Required('error_code', type: new ConstantOf('plugin_name_taken'))]
    public string $errorCode = 'plugin_name_taken';

    #[Optional('plugin_id', nullable: true)]
    public ?string $pluginID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $pluginID = null): self
    {
        $self = new self;

        null !== $pluginID && $self['pluginID'] = $pluginID;

        return $self;
    }

    /**
     * @param 'plugin_name_taken' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    public function withPluginID(?string $pluginID): self
    {
        $self = clone $this;
        $self['pluginID'] = $pluginID;

        return $self;
    }
}
