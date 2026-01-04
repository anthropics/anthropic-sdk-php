<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will not be allowed to use tools.
 *
 * @phpstan-type BetaToolChoiceNoneShape = array{type: 'none'}
 */
final class BetaToolChoiceNone implements BaseModel
{
    /** @use SdkModel<BetaToolChoiceNoneShape> */
    use SdkModel;

    /** @var 'none' $type */
    #[Required]
    public string $type = 'none';

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
}
