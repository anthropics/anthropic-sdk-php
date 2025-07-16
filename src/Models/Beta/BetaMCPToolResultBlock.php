<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class BetaMCPToolResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'mcp_tool_result';

    /** @var list<BetaTextBlock>|string $content */
    #[Api(type: new UnionOf(['string', new ListOf(BetaTextBlock::class)]))]
    public array|string $content;

    #[Api('is_error')]
    public bool $isError = false;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<BetaTextBlock>|string $content
     */
    final public function __construct(
        array|string $content,
        string $toolUseID,
        bool $isError = false
    ) {
        $this->content = $content;
        $this->isError = $isError;
        $this->toolUseID = $toolUseID;
    }
}

BetaMCPToolResultBlock::_loadMetadata();
