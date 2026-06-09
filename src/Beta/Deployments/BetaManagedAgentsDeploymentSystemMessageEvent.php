<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentSystemMessageEvent\Type;
use Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Privileged context for the accompanying turn and all subsequent turns, appended to the session's system context as a `role: "system"` turn rather than replacing the top-level system prompt.
 *
 * @phpstan-import-type BetaManagedAgentsSystemContentBlockShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock
 *
 * @phpstan-type BetaManagedAgentsDeploymentSystemMessageEventShape = array{
 *   content: list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape>,
 *   type: Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsDeploymentSystemMessageEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeploymentSystemMessageEventShape> */
    use SdkModel;

    /**
     * System content blocks to append. Text-only.
     *
     * @var list<BetaManagedAgentsSystemContentBlock> $content
     */
    #[Required(list: BetaManagedAgentsSystemContentBlock::class)]
    public array $content;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsDeploymentSystemMessageEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeploymentSystemMessageEvent::with(content: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeploymentSystemMessageEvent)
     *   ->withContent(...)
     *   ->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(array $content, Type|string $type): self
    {
        $self = new self;

        $self['content'] = $content;
        $self['type'] = $type;

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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
