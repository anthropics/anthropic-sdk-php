<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type beta_request_mcp_server_tool_configuration_alias = array{
 *   allowedTools?: list<string>|null, enabled?: bool|null
 * }
 */
final class BetaRequestMCPServerToolConfiguration implements BaseModel
{
    use Model;

    /** @var null|list<string> $allowedTools */
    #[Api(
        'allowed_tools',
        type: new ListOf('string'),
        nullable: true,
        optional: true
    )]
    public ?array $allowedTools;

    #[Api(optional: true)]
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
     * @param null|list<string> $allowedTools
     */
    public static function new(
        ?array $allowedTools = null,
        ?bool $enabled = null
    ): self {
        $obj = new self;

        null !== $allowedTools && $obj->allowedTools = $allowedTools;
        null !== $enabled && $obj->enabled = $enabled;

        return $obj;
    }

    /**
     * @param null|list<string> $allowedTools
     */
    public function setAllowedTools(?array $allowedTools): self
    {
        $this->allowedTools = $allowedTools;

        return $this;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
}
