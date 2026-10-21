<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams\Content;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Parameters for sending a user message to the session.
 *
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams\Content
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams\Content
 *
 * @phpstan-type ManagedAgentsUserMessageEventParamsShape = array{
 *   content: list<ContentShape>, type: 'user.message'
 * }
 */
final class ManagedAgentsUserMessageEventParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserMessageEventParamsShape> */
    use SdkModel;

    /** @var 'user.message' $type */
    #[Required(type: new ConstantOf('user.message'))]
    public string $type = 'user.message';

    /**
     * Array of content blocks for the user message.
     *
     * @var list<ContentVariants> $content
     */
    #[Required(list: Content::class)]
    public array $content;

    /**
     * `new ManagedAgentsUserMessageEventParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserMessageEventParams::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserMessageEventParams())->withContent(...)
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
     * @param list<ContentShape> $content
     */
    public static function with(array $content): self
    {
        $self = new self;

        $self['content'] = $content;

        return $self;
    }

    /**
     * Array of content blocks for the user message.
     *
     * @param list<ContentShape> $content
     */
    public function withContent(array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param 'user.message' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
