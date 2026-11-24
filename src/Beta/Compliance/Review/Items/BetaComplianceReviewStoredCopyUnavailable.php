<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A copy of the message was stored and can't be returned.
 *
 * @phpstan-type BetaComplianceReviewStoredCopyUnavailableShape = array{
 *   type: 'stored_copy_unavailable'
 * }
 */
final class BetaComplianceReviewStoredCopyUnavailable implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewStoredCopyUnavailableShape> */
    use SdkModel;

    /** @var 'stored_copy_unavailable' $type */
    #[Required(type: new ConstantOf('stored_copy_unavailable'))]
    public string $type = 'stored_copy_unavailable';

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
     * @param 'stored_copy_unavailable' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
