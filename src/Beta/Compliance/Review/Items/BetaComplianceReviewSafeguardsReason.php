<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic flagged the item for your organization to review.
 *
 * @phpstan-type BetaComplianceReviewSafeguardsReasonShape = array{
 *   type: 'safeguards_review'
 * }
 */
final class BetaComplianceReviewSafeguardsReason implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewSafeguardsReasonShape> */
    use SdkModel;

    /** @var 'safeguards_review' $type */
    #[Required(type: new ConstantOf('safeguards_review'))]
    public string $type = 'safeguards_review';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'safeguards_review' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
