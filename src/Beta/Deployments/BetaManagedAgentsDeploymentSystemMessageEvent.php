<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Privileged context for the accompanying turn and all subsequent turns, appended to the session's system context as a `role: "system"` turn rather than replacing the top-level system prompt.
 *
 * @phpstan-import-type BetaManagedAgentsSystemContentBlockShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock
 *
 * @phpstan-type BetaManagedAgentsDeploymentSystemMessageEventShape = array{
 *   content: list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape>,
 *   type: 'system.message',
 * }
 */
final class BetaManagedAgentsDeploymentSystemMessageEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeploymentSystemMessageEventShape> */
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
     * `new BetaManagedAgentsDeploymentSystemMessageEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeploymentSystemMessageEvent::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeploymentSystemMessageEvent())->withContent(...)
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
