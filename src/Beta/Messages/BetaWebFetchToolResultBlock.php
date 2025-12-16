<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlock\Content
 *
 * @phpstan-type BetaWebFetchToolResultBlockShape = array{
 *   content: BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock|ContentShape,
 *   toolUseID: string,
 *   type: 'web_fetch_tool_result',
 * }
 */
final class BetaWebFetchToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaWebFetchToolResultBlockShape> */
    use SdkModel;

    /** @var 'web_fetch_tool_result' $type */
    #[Required]
    public string $type = 'web_fetch_tool_result';

    #[Required]
    public BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaWebFetchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebFetchToolResultBlock)->withContent(...)->withToolUseID(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ContentShape $content
     */
    public static function with(
        BetaWebFetchToolResultErrorBlock|array|BetaWebFetchBlock $content,
        string $toolUseID,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param ContentShape $content
     */
    public function withContent(
        BetaWebFetchToolResultErrorBlock|array|BetaWebFetchBlock $content
    ): self {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }
}
