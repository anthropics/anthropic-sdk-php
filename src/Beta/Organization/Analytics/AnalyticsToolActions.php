<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-tool accepted/rejected counts for Claude Code file modification tools.
 *
 * @phpstan-import-type AnalyticsToolActionCountsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsToolActionCounts
 *
 * @phpstan-type AnalyticsToolActionsShape = array{
 *   editTool: AnalyticsToolActionCounts|AnalyticsToolActionCountsShape,
 *   multiEditTool: AnalyticsToolActionCounts|AnalyticsToolActionCountsShape,
 *   notebookEditTool: AnalyticsToolActionCounts|AnalyticsToolActionCountsShape,
 *   writeTool: AnalyticsToolActionCounts|AnalyticsToolActionCountsShape,
 * }
 */
final class AnalyticsToolActions implements BaseModel
{
    /** @use SdkModel<AnalyticsToolActionsShape> */
    use SdkModel;

    /**
     * Accepted/rejected counts for a single Claude Code tool type.
     */
    #[Required('edit_tool')]
    public AnalyticsToolActionCounts $editTool;

    /**
     * Accepted/rejected counts for a single Claude Code tool type.
     */
    #[Required('multi_edit_tool')]
    public AnalyticsToolActionCounts $multiEditTool;

    /**
     * Accepted/rejected counts for a single Claude Code tool type.
     */
    #[Required('notebook_edit_tool')]
    public AnalyticsToolActionCounts $notebookEditTool;

    /**
     * Accepted/rejected counts for a single Claude Code tool type.
     */
    #[Required('write_tool')]
    public AnalyticsToolActionCounts $writeTool;

    /**
     * `new AnalyticsToolActions()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsToolActions::with(
     *   editTool: ..., multiEditTool: ..., notebookEditTool: ..., writeTool: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsToolActions)
     *   ->withEditTool(...)
     *   ->withMultiEditTool(...)
     *   ->withNotebookEditTool(...)
     *   ->withWriteTool(...)
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
     * @param AnalyticsToolActionCounts|AnalyticsToolActionCountsShape $editTool
     * @param AnalyticsToolActionCounts|AnalyticsToolActionCountsShape $multiEditTool
     * @param AnalyticsToolActionCounts|AnalyticsToolActionCountsShape $notebookEditTool
     * @param AnalyticsToolActionCounts|AnalyticsToolActionCountsShape $writeTool
     */
    public static function with(
        AnalyticsToolActionCounts|array $editTool,
        AnalyticsToolActionCounts|array $multiEditTool,
        AnalyticsToolActionCounts|array $notebookEditTool,
        AnalyticsToolActionCounts|array $writeTool,
    ): self {
        $self = new self;

        $self['editTool'] = $editTool;
        $self['multiEditTool'] = $multiEditTool;
        $self['notebookEditTool'] = $notebookEditTool;
        $self['writeTool'] = $writeTool;

        return $self;
    }

    /**
     * Accepted/rejected counts for a single Claude Code tool type.
     *
     * @param AnalyticsToolActionCounts|AnalyticsToolActionCountsShape $editTool
     */
    public function withEditTool(
        AnalyticsToolActionCounts|array $editTool
    ): self {
        $self = clone $this;
        $self['editTool'] = $editTool;

        return $self;
    }

    /**
     * Accepted/rejected counts for a single Claude Code tool type.
     *
     * @param AnalyticsToolActionCounts|AnalyticsToolActionCountsShape $multiEditTool
     */
    public function withMultiEditTool(
        AnalyticsToolActionCounts|array $multiEditTool
    ): self {
        $self = clone $this;
        $self['multiEditTool'] = $multiEditTool;

        return $self;
    }

    /**
     * Accepted/rejected counts for a single Claude Code tool type.
     *
     * @param AnalyticsToolActionCounts|AnalyticsToolActionCountsShape $notebookEditTool
     */
    public function withNotebookEditTool(
        AnalyticsToolActionCounts|array $notebookEditTool
    ): self {
        $self = clone $this;
        $self['notebookEditTool'] = $notebookEditTool;

        return $self;
    }

    /**
     * Accepted/rejected counts for a single Claude Code tool type.
     *
     * @param AnalyticsToolActionCounts|AnalyticsToolActionCountsShape $writeTool
     */
    public function withWriteTool(
        AnalyticsToolActionCounts|array $writeTool
    ): self {
        $self = clone $this;
        $self['writeTool'] = $writeTool;

        return $self;
    }
}
