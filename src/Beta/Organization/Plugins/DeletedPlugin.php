<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type DeletedPluginShape = array{id: string, type: 'plugin_deleted'}
 */
final class DeletedPlugin implements BaseModel
{
    /** @use SdkModel<DeletedPluginShape> */
    use SdkModel;

    /**
     * Always `plugin_deleted`.
     *
     * @var 'plugin_deleted' $type
     */
    #[Required(type: new ConstantOf('plugin_deleted'))]
    public string $type = 'plugin_deleted';

    /**
     * The deleted Plugin's ID.
     */
    #[Required]
    public string $id;

    /**
     * `new DeletedPlugin()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeletedPlugin::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeletedPlugin)->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    /**
     * The deleted Plugin's ID.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Always `plugin_deleted`.
     *
     * @param 'plugin_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
