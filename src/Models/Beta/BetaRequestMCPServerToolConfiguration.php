<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

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

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<string> $allowedTools
     */
    final public function __construct(
        ?array $allowedTools = null,
        ?bool $enabled = null
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $allowedTools && $this->allowedTools = $allowedTools;
        null !== $enabled && $this->enabled = $enabled;
    }
}
