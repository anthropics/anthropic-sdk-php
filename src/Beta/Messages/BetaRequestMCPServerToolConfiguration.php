<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRequestMCPServerToolConfiguration implements BaseModel
{
    use SdkModel;

    /** @var list<string>|null $allowedTools */
    #[Api('allowed_tools', list: 'string', nullable: true, optional: true)]
    public ?array $allowedTools;

    #[Api(nullable: true, optional: true)]
    public ?bool $enabled;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
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

        null !== $allowedTools && $obj->allowedTools = $allowedTools;
        null !== $enabled && $obj->enabled = $enabled;

        return $obj;
    }

    /**
     * @param list<string>|null $allowedTools
     */
    public function withAllowedTools(?array $allowedTools): self
    {
        $obj = clone $this;
        $obj->allowedTools = $allowedTools;

        return $obj;
    }

    public function withEnabled(?bool $enabled): self
    {
        $obj = clone $this;
        $obj->enabled = $enabled;

        return $obj;
    }
}
