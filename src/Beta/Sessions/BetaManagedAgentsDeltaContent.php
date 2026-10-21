<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ManagedAgentsTextBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock
 *
 * @phpstan-type BetaManagedAgentsDeltaContentShape = array{
 *   content: ManagedAgentsTextBlock|ManagedAgentsTextBlockShape,
 *   type: 'content_delta',
 *   index?: int|null,
 * }
 */
final class BetaManagedAgentsDeltaContent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeltaContentShape> */
    use SdkModel;

    /** @var 'content_delta' $type */
    #[Required(type: new ConstantOf('content_delta'))]
    public string $type = 'content_delta';

    /**
     * A partial element of the content array at index, typed like the element itself — the same shape the buffered agent.message carries in content.
     */
    #[Required]
    public ManagedAgentsTextBlock $content;

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
     * BetaManagedAgentsDeltaContent::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeltaContent())->withContent(...)
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
     */
    public static function with(
        ManagedAgentsTextBlock|array $content,
        ?int $index = null
    ): self {
        $self = new self;

        $self['content'] = $content;

        null !== $index && $self['index'] = $index;

        return $self;
    }

    /**
     * A partial element of the content array at index, typed like the element itself — the same shape the buffered agent.message carries in content.
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
     * @param 'content_delta' $type
     */
    public function withType(string $type): self
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
