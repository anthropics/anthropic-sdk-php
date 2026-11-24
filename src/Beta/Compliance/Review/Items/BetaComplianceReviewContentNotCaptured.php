<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * No copy of the message was stored.
 *
 * @phpstan-type BetaComplianceReviewContentNotCapturedShape = array{
 *   type: 'not_captured'
 * }
 */
final class BetaComplianceReviewContentNotCaptured implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewContentNotCapturedShape> */
    use SdkModel;

    /** @var 'not_captured' $type */
    #[Required(type: new ConstantOf('not_captured'))]
    public string $type = 'not_captured';

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
     * @param 'not_captured' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
