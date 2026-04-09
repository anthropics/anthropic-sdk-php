<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Messages\BetaAdvisorToolResultBlock\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaAdvisorToolResultBlock\Content
 *
 * @phpstan-type BetaAdvisorToolResultBlockShape = array{
 *   content: ContentShape, toolUseID: string, type: 'advisor_tool_result'
 * }
 */
final class BetaAdvisorToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaAdvisorToolResultBlockShape> */
    use SdkModel;

    /** @var 'advisor_tool_result' $type */
    #[Required]
    public string $type = 'advisor_tool_result';

    /** @var ContentVariants $content */
    #[Required]
    public BetaAdvisorToolResultError|BetaAdvisorResultBlock|BetaAdvisorRedactedResultBlock $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new BetaAdvisorToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAdvisorToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAdvisorToolResultBlock)->withContent(...)->withToolUseID(...)
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
        BetaAdvisorToolResultError|array|BetaAdvisorResultBlock|BetaAdvisorRedactedResultBlock $content,
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
        BetaAdvisorToolResultError|array|BetaAdvisorResultBlock|BetaAdvisorRedactedResultBlock $content,
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

    /**
     * @param 'advisor_tool_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
