<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRequestMCPServerToolConfigurationShape = array{
 *   allowedTools?: list<string>|null, enabled?: bool|null
 * }
 */
final class BetaRequestMCPServerToolConfiguration implements BaseModel
{
    /** @use SdkModel<BetaRequestMCPServerToolConfigurationShape> */
    use SdkModel;

    /** @var list<string>|null $allowedTools */
    #[Optional('allowed_tools', list: 'string', nullable: true)]
    public ?array $allowedTools;

    #[Optional(nullable: true)]
    public ?bool $enabled;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $allowedTools
     */
    public static function with(
        ?array $allowedTools = null,
        ?bool $enabled = null
    ): self {
        $obj = new self;

        null !== $allowedTools && $obj['allowedTools'] = $allowedTools;
        null !== $enabled && $obj['enabled'] = $enabled;

        return $obj;
    }

    /**
     * @param list<string>|null $allowedTools
     */
    public function withAllowedTools(?array $allowedTools): self
    {
        $obj = clone $this;
        $obj['allowedTools'] = $allowedTools;

        return $obj;
    }

    public function withEnabled(?bool $enabled): self
    {
        $obj = clone $this;
        $obj['enabled'] = $enabled;

        return $obj;
    }
}
