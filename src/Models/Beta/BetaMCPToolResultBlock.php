<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaMCPToolResultBlock\Content;

/**
 * @phpstan-type beta_mcp_tool_result_block_alias = array{
 *   content: string|list<BetaTextBlock>,
 *   isError: bool,
 *   toolUseID: string,
 *   type: string,
 * }
 */
final class BetaMCPToolResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'mcp_tool_result';

    /** @var list<BetaTextBlock>|string $content */
    #[Api(union: Content::class)]
    public array|string $content;

    #[Api('is_error')]
    public bool $isError;

    #[Api('tool_use_id')]
    public string $toolUseID;

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
     * @param list<BetaTextBlock>|string $content
     */
    public static function new(
        array|string $content,
        string $toolUseID,
        bool $isError = false
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->isError = $isError;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    /**
     * @param list<BetaTextBlock>|string $content
     */
    public function setContent(array|string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setIsError(bool $isError): self
    {
        $this->isError = $isError;

        return $this;
    }

    public function setToolUseID(string $toolUseID): self
    {
        $this->toolUseID = $toolUseID;

        return $this;
    }
}
