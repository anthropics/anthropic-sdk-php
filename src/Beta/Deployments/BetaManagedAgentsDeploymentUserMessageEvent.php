<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserMessageEvent\Content;
use Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserMessageEvent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A user message sent to the session.
 *
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserMessageEvent\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserMessageEvent\Content
 *
 * @phpstan-type BetaManagedAgentsDeploymentUserMessageEventShape = array{
 *   content: list<ContentShape>, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsDeploymentUserMessageEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeploymentUserMessageEventShape> */
    use SdkModel;

    /**
     * Array of content blocks for the user message.
     *
     * @var list<ContentVariants> $content
     */
    #[Required(list: Content::class)]
    public array $content;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsDeploymentUserMessageEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeploymentUserMessageEvent::with(content: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeploymentUserMessageEvent)
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
     * @param list<ContentShape> $content
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
