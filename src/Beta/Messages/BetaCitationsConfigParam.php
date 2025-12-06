<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCitationsConfigParamShape = array{enabled?: bool|null}
 */
final class BetaCitationsConfigParam implements BaseModel
{
    /** @use SdkModel<BetaCitationsConfigParamShape> */
    use SdkModel;

    #[Api(optional: true)]
    public ?bool $enabled;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $enabled = null): self
    {
        $obj = new self;

        null !== $enabled && $obj['enabled'] = $enabled;

        return $obj;
    }

    public function withEnabled(bool $enabled): self
    {
        $obj = clone $this;
        $obj['enabled'] = $enabled;

        return $obj;
    }
}
