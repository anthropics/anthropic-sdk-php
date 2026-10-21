<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Privileged context for the accompanying turn and all subsequent turns, appended to the session's system context as a `role: "system"` turn rather than replacing the top-level system prompt. At most one per request: it must be the final event and immediately follow the `user.message`, `user.tool_result`, or `user.custom_tool_result` it accompanies. Only supported on models that accept mid-conversation system messages.
 *
 * @phpstan-import-type BetaManagedAgentsSystemContentBlockShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock
 *
 * @phpstan-type ManagedAgentsSystemMessageEventParamsShape = array{
 *   content: list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape>,
 *   type: 'system.message',
 * }
 */
final class ManagedAgentsSystemMessageEventParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSystemMessageEventParamsShape> */
    use SdkModel;

    /** @var 'system.message' $type */
    #[Required(type: new ConstantOf('system.message'))]
    public string $type = 'system.message';

    /**
     * System content blocks to append. Text-only.
     *
     * @var list<BetaManagedAgentsSystemContentBlock> $content
     */
    #[Required(list: BetaManagedAgentsSystemContentBlock::class)]
    public array $content;

    /**
     * `new ManagedAgentsSystemMessageEventParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSystemMessageEventParams::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSystemMessageEventParams())->withContent(...)
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
     * @param list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape> $content
     */
    public static function with(array $content): self
    {
        $self = new self;

        $self['content'] = $content;

        return $self;
    }

    /**
     * System content blocks to append. Text-only.
     *
     * @param list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape> $content
     */
    public function withContent(array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param 'system.message' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
