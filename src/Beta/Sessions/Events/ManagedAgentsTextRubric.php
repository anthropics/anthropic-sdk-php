<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Rubric content provided inline as text.
 *
 * @phpstan-type ManagedAgentsTextRubricShape = array{
 *   content: string, type: 'text'
 * }
 */
final class ManagedAgentsTextRubric implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTextRubricShape> */
    use SdkModel;

    /** @var 'text' $type */
    #[Required(type: new ConstantOf('text'))]
    public string $type = 'text';

    /**
     * Rubric content. Plain text or markdown — the grader treats it as freeform text.
     */
    #[Required]
    public string $content;

    /**
     * `new ManagedAgentsTextRubric()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTextRubric::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTextRubric())->withContent(...)
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
    public static function with(string $content): self
    {
        $self = new self;

        $self['content'] = $content;

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
     * @param 'text' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
