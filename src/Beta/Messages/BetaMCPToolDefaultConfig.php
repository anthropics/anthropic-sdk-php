<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Default configuration for tools in an MCP toolset.
 *
 * @phpstan-type BetaMCPToolDefaultConfigShape = array{
 *   deferLoading?: bool|null, enabled?: bool|null
 * }
 */
final class BetaMCPToolDefaultConfig implements BaseModel
{
    /** @use SdkModel<BetaMCPToolDefaultConfigShape> */
    use SdkModel;

    #[Optional('defer_loading')]
    public ?bool $deferLoading;

    #[Optional]
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
    public static function with(
        ?bool $deferLoading = null,
        ?bool $enabled = null
    ): self {
        $obj = new self;

        null !== $deferLoading && $obj['deferLoading'] = $deferLoading;
        null !== $enabled && $obj['enabled'] = $enabled;

        return $obj;
    }

    public function withDeferLoading(bool $deferLoading): self
    {
        $obj = clone $this;
        $obj['deferLoading'] = $deferLoading;

        return $obj;
    }

    public function withEnabled(bool $enabled): self
    {
        $obj = clone $this;
        $obj['enabled'] = $enabled;

        return $obj;
    }
}
