<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserDefineOutcomeEvent\Rubric;
use Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserDefineOutcomeEvent\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubric;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubric;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An outcome the agent should work toward. The agent begins work on receipt.
 *
 * @phpstan-import-type RubricVariants from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserDefineOutcomeEvent\Rubric
 * @phpstan-import-type RubricShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserDefineOutcomeEvent\Rubric
 *
 * @phpstan-type BetaManagedAgentsDeploymentUserDefineOutcomeEventShape = array{
 *   description: string,
 *   rubric: RubricShape,
 *   type: Type|value-of<Type>,
 *   maxIterations?: int|null,
 * }
 */
final class BetaManagedAgentsDeploymentUserDefineOutcomeEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeploymentUserDefineOutcomeEventShape> */
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
    public ManagedAgentsFileRubric|ManagedAgentsTextRubric $rubric;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Eval→revision cycles before giving up. Default 3, max 20.
     */
    #[Optional('max_iterations', nullable: true)]
    public ?int $maxIterations;

    /**
     * `new BetaManagedAgentsDeploymentUserDefineOutcomeEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeploymentUserDefineOutcomeEvent::with(
     *   description: ..., rubric: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeploymentUserDefineOutcomeEvent)
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
        ManagedAgentsFileRubric|array|ManagedAgentsTextRubric $rubric,
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
        ManagedAgentsFileRubric|array|ManagedAgentsTextRubric $rubric
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
