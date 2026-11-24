<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An action that Anthropic took on the flagged traffic.
 *
 * @phpstan-type BetaComplianceReviewEnforcementActionShape = array{type: string}
 */
final class BetaComplianceReviewEnforcementAction implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewEnforcementActionShape> */
    use SdkModel;

    /**
     * The kind of action. New values can appear, so accept a value that you don't know.
     */
    #[Required]
    public string $type;

    /**
     * `new BetaComplianceReviewEnforcementAction()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewEnforcementAction::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewEnforcementAction())->withType(...)
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
    public static function with(string $type): self
    {
        $self = new self;

        $self['type'] = $type;

        return $self;
    }

    /**
     * The kind of action. New values can appear, so accept a value that you don't know.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
