<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic is waiting for a response to the case.
 *
 * @phpstan-type BetaComplianceReviewCaseOpenShape = array{type: 'open'}
 */
final class BetaComplianceReviewCaseOpen implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewCaseOpenShape> */
    use SdkModel;

    /** @var 'open' $type */
    #[Required(type: new ConstantOf('open'))]
    public string $type = 'open';

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
     * @param 'open' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
