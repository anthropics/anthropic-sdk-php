<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSearchResultBlock\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A block containing a web search result.
 *
 * @phpstan-import-type ManagedAgentsSearchResultCitationsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSearchResultCitations
 * @phpstan-import-type ManagedAgentsSearchResultContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSearchResultContent
 *
 * @phpstan-type ManagedAgentsSearchResultBlockShape = array{
 *   citations: ManagedAgentsSearchResultCitations|ManagedAgentsSearchResultCitationsShape,
 *   content: list<ManagedAgentsSearchResultContent|ManagedAgentsSearchResultContentShape>,
 *   source: string,
 *   title: string,
 *   toolUseID: string,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsSearchResultBlock implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSearchResultBlockShape> */
    use SdkModel;

    /**
     * Citation settings for a search result.
     */
    #[Required]
    public ManagedAgentsSearchResultCitations $citations;

    /**
     * Array of text content blocks from the search result.
     *
     * @var list<ManagedAgentsSearchResultContent> $content
     */
    #[Required(list: ManagedAgentsSearchResultContent::class)]
    public array $content;

    /**
     * The URL source of the search result.
     */
    #[Required]
    public string $source;

    /**
     * The title of the search result.
     */
    #[Required]
    public string $title;

    /**
     * The ID of the tool use that produced this search result.
     */
    #[Required('tool_use_id')]
    public string $toolUseID;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsSearchResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSearchResultBlock::with(
     *   citations: ...,
     *   content: ...,
     *   source: ...,
     *   title: ...,
     *   toolUseID: ...,
     *   type: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSearchResultBlock)
     *   ->withCitations(...)
     *   ->withContent(...)
     *   ->withSource(...)
     *   ->withTitle(...)
     *   ->withToolUseID(...)
     *   ->withType(...)
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
     * @param ManagedAgentsSearchResultCitations|ManagedAgentsSearchResultCitationsShape $citations
     * @param list<ManagedAgentsSearchResultContent|ManagedAgentsSearchResultContentShape> $content
     * @param Type|value-of<Type> $type
     */
    public static function with(
        ManagedAgentsSearchResultCitations|array $citations,
        array $content,
        string $source,
        string $title,
        string $toolUseID,
        Type|string $type,
    ): self {
        $self = new self;

        $self['citations'] = $citations;
        $self['content'] = $content;
        $self['source'] = $source;
        $self['title'] = $title;
        $self['toolUseID'] = $toolUseID;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Citation settings for a search result.
     *
     * @param ManagedAgentsSearchResultCitations|ManagedAgentsSearchResultCitationsShape $citations
     */
    public function withCitations(
        ManagedAgentsSearchResultCitations|array $citations
    ): self {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }

    /**
     * Array of text content blocks from the search result.
     *
     * @param list<ManagedAgentsSearchResultContent|ManagedAgentsSearchResultContentShape> $content
     */
    public function withContent(array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * The URL source of the search result.
     */
    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * The title of the search result.
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * The ID of the tool use that produced this search result.
     */
    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
