<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type PluginAPIActorShape = array{apiKeyID: string, type: 'api_actor'}
 */
final class PluginAPIActor implements BaseModel
{
    /** @use SdkModel<PluginAPIActorShape> */
    use SdkModel;

    /**
     * An Admin API key, in the same form the Compliance API activity feed uses for it.
     *
     * @var 'api_actor' $type
     */
    #[Required(type: new ConstantOf('api_actor'))]
    public string $type = 'api_actor';

    /**
     * The key's ID.
     */
    #[Required('api_key_id')]
    public string $apiKeyID;

    /**
     * `new PluginAPIActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginAPIActor::with(apiKeyID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginAPIActor())->withAPIKeyID(...)
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
    public static function with(string $apiKeyID): self
    {
        $self = new self;

        $self['apiKeyID'] = $apiKeyID;

        return $self;
    }

    /**
     * The key's ID.
     */
    public function withAPIKeyID(string $apiKeyID): self
    {
        $self = clone $this;
        $self['apiKeyID'] = $apiKeyID;

        return $self;
    }

    /**
     * An Admin API key, in the same form the Compliance API activity feed uses for it.
     *
     * @param 'api_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
