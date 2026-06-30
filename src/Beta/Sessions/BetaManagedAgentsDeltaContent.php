<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsDeltaContent\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ManagedAgentsTextBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock
 *
 * @phpstan-type BetaManagedAgentsDeltaContentShape = array{
 *   content: ManagedAgentsTextBlock|ManagedAgentsTextBlockShape,
 *   type: Type|value-of<Type>,
 *   index?: int|null,
 * }
 */
final class BetaManagedAgentsDeltaContent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeltaContentShape> */
    use SdkModel;

    /**
     * Regular text content.
     */
    #[Required]
    public ManagedAgentsTextBlock $content;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Which entry in the previewed event's content array this fragment lands in. Insert content as that entry when the index is new; append to the existing entry otherwise.
     */
    #[Optional]
    public ?int $index;

    /**
     * `new BetaManagedAgentsDeltaContent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeltaContent::with(content: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeltaContent)->withContent(...)->withType(...)
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
     * @param ManagedAgentsTextBlock|ManagedAgentsTextBlockShape $content
     * @param Type|value-of<Type> $type
     */
    public static function with(
        ManagedAgentsTextBlock|array $content,
        Type|string $type,
        ?int $index = null
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['type'] = $type;

        null !== $index && $self['index'] = $index;

        return $self;
    }

    /**
     * Regular text content.
     *
     * @param ManagedAgentsTextBlock|ManagedAgentsTextBlockShape $content
     */
    public function withContent(ManagedAgentsTextBlock|array $content): self
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

    /**
     * Which entry in the previewed event's content array this fragment lands in. Insert content as that entry when the index is new; append to the existing entry otherwise.
     */
    public function withIndex(int $index): self
    {
        $self = clone $this;
        $self['index'] = $index;

        return $self;
    }
}
