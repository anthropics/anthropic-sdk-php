<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubricParams\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Rubric content provided inline as text.
 *
 * @phpstan-type ManagedAgentsTextRubricParamsShape = array{
 *   content: string, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsTextRubricParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTextRubricParamsShape> */
    use SdkModel;

    /**
     * Rubric content. Plain text or markdown — the grader treats it as freeform text. Maximum 262144 characters.
     */
    #[Required]
    public string $content;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsTextRubricParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTextRubricParams::with(content: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTextRubricParams)->withContent(...)->withType(...)
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
     * Rubric content. Plain text or markdown — the grader treats it as freeform text. Maximum 262144 characters.
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
