<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams\Rubric;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for defining an outcome the agent should work toward. The agent begins work on receipt.
 *
 * @phpstan-import-type RubricVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams\Rubric
 * @phpstan-import-type RubricShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams\Rubric
 *
 * @phpstan-type ManagedAgentsUserDefineOutcomeEventParamsShape = array{
 *   description: string,
 *   rubric: RubricShape,
 *   type: Type|value-of<Type>,
 *   maxIterations?: int|null,
 * }
 */
final class ManagedAgentsUserDefineOutcomeEventParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUserDefineOutcomeEventParamsShape> */
    use SdkModel;

    /**
     * What the agent should produce. This is the task specification.
     */
    #[Required]
    public string $description;

    /**
     * Rubric for grading the quality of an outcome.
     *
     * @var RubricVariants $rubric
     */
    #[Required(union: Rubric::class)]
    public ManagedAgentsFileRubricParams|ManagedAgentsTextRubricParams $rubric;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Eval→revision cycles before giving up. Default 3, max 20.
     */
    #[Optional('max_iterations', nullable: true)]
    public ?int $maxIterations;

    /**
     * `new ManagedAgentsUserDefineOutcomeEventParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUserDefineOutcomeEventParams::with(
     *   description: ..., rubric: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUserDefineOutcomeEventParams)
     *   ->withDescription(...)
     *   ->withRubric(...)
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
     * @param RubricShape $rubric
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $description,
        ManagedAgentsFileRubricParams|array|ManagedAgentsTextRubricParams $rubric,
        Type|string $type,
        ?int $maxIterations = null,
    ): self {
        $self = new self;

        $self['description'] = $description;
        $self['rubric'] = $rubric;
        $self['type'] = $type;

        null !== $maxIterations && $self['maxIterations'] = $maxIterations;

        return $self;
    }

    /**
     * What the agent should produce. This is the task specification.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Rubric for grading the quality of an outcome.
     *
     * @param RubricShape $rubric
     */
    public function withRubric(
        ManagedAgentsFileRubricParams|array|ManagedAgentsTextRubricParams $rubric
    ): self {
        $self = clone $this;
        $self['rubric'] = $rubric;

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
     * Eval→revision cycles before giving up. Default 3, max 20.
     */
    public function withMaxIterations(?int $maxIterations): self
    {
        $self = clone $this;
        $self['maxIterations'] = $maxIterations;

        return $self;
    }
}
