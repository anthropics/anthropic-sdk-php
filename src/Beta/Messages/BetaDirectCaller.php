<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Tool invocation directly from the model.
 *
 * @phpstan-type BetaDirectCallerShape = array{type: 'direct'}
 */
final class BetaDirectCaller implements BaseModel
{
    /** @use SdkModel<BetaDirectCallerShape> */
    use SdkModel;

    /** @var 'direct' $type */
    #[Required]
    public string $type = 'direct';

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
