<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaThinkingConfigDisabledShape = array{type: 'disabled'}
 */
final class BetaThinkingConfigDisabled implements BaseModel
{
    /** @use SdkModel<BetaThinkingConfigDisabledShape> */
    use SdkModel;

    /** @var 'disabled' $type */
    #[Required]
    public string $type = 'disabled';

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
