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
        $self = new self;

        null !== $allowedTools && $self['allowedTools'] = $allowedTools;
        null !== $enabled && $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * @param list<string>|null $allowedTools
     */
    public function withAllowedTools(?array $allowedTools): self
    {
        $self = clone $this;
        $self['allowedTools'] = $allowedTools;

        return $self;
    }

    public function withEnabled(?bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }
}
