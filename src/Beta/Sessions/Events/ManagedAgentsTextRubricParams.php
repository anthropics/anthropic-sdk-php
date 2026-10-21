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
 * @phpstan-type ManagedAgentsTextRubricParamsShape = array{
 *   content: string, type: 'text'
 * }
 */
final class ManagedAgentsTextRubricParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTextRubricParamsShape> */
    use SdkModel;

    /** @var 'text' $type */
    #[Required(type: new ConstantOf('text'))]
    public string $type = 'text';

    /**
     * Rubric content. Plain text or markdown — the grader treats it as freeform text. Maximum 262144 characters.
     */
    #[Required]
    public string $content;

    /**
     * `new ManagedAgentsTextRubricParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTextRubricParams::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTextRubricParams())->withContent(...)
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
     * Rubric content. Plain text or markdown — the grader treats it as freeform text. Maximum 262144 characters.
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
