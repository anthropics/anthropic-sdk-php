<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubric\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Rubric content provided inline as text.
 *
 * @phpstan-type ManagedAgentsTextRubricShape = array{
 *   content: string, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsTextRubric implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTextRubricShape> */
    use SdkModel;

    /**
     * Rubric content. Plain text or markdown — the grader treats it as freeform text.
     */
    #[Required]
    public string $content;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsTextRubric()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTextRubric::with(content: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTextRubric)->withContent(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(string $content, Type|string $type): self
    {
        $self = new self;

        $self['content'] = $content;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Rubric content. Plain text or markdown — the grader treats it as freeform text.
     */
    public function withContent(string $content): self
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
