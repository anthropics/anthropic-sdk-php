<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRequestMCPServerToolConfigurationShape = array{
 *   allowed_tools?: list<string>|null, enabled?: bool|null
 * }
 */
final class BetaRequestMCPServerToolConfiguration implements BaseModel
{
    /** @use SdkModel<BetaRequestMCPServerToolConfigurationShape> */
    use SdkModel;

    /** @var list<string>|null $allowed_tools */
    #[Optional(list: 'string', nullable: true)]
    public ?array $allowed_tools;

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
     * @param list<string>|null $allowed_tools
     */
    public static function with(
        ?array $allowed_tools = null,
        ?bool $enabled = null
    ): self {
        $obj = new self;

        null !== $allowed_tools && $obj['allowed_tools'] = $allowed_tools;
        null !== $enabled && $obj['enabled'] = $enabled;

        return $obj;
    }

    /**
     * @param list<string>|null $allowedTools
     */
    public function withAllowedTools(?array $allowedTools): self
    {
        $obj = clone $this;
        $obj['allowed_tools'] = $allowedTools;

        return $obj;
    }

    public function withEnabled(?bool $enabled): self
    {
        $obj = clone $this;
        $obj['enabled'] = $enabled;

        return $obj;
    }
}
