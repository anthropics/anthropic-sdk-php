<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\MessageParam\Content;
use Anthropic\Messages\MessageParam\Role;

/**
 * @phpstan-type MessageParamShape = array{
 *   content: string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam>,
 *   role: value-of<Role>,
 * }
 */
final class MessageParam implements BaseModel
{
    /** @use SdkModel<MessageParamShape> */
    use SdkModel;

    /**
     * @var string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam> $content
     */
    #[Required(union: Content::class)]
    public string|array $content;

    /** @var value-of<Role> $role */
    #[Required(enum: Role::class)]
    public string $role;

    /**
     * `new MessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageParam::with(content: ..., role: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageParam)->withContent(...)->withRole(...)
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
     * @param string|list<TextBlockParam|array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
     * }|ImageBlockParam|array{
     *   source: Base64ImageSource|URLImageSource,
     *   type?: 'image',
     *   cacheControl?: CacheControlEphemeral|null,
     * }|DocumentBlockParam|array{
     *   source: Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource,
     *   type?: 'document',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: CitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * }|SearchResultBlockParam|array{
     *   content: list<TextBlockParam>,
     *   source: string,
     *   title: string,
     *   type?: 'search_result',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: CitationsConfigParam|null,
     * }|ThinkingBlockParam|array{
     *   signature: string, thinking: string, type?: 'thinking'
     * }|RedactedThinkingBlockParam|array{
     *   data: string, type?: 'redacted_thinking'
     * }|ToolUseBlockParam|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   type?: 'tool_use',
     *   cacheControl?: CacheControlEphemeral|null,
     * }|ToolResultBlockParam|array{
     *   toolUseID: string,
     *   type?: 'tool_result',
     *   cacheControl?: CacheControlEphemeral|null,
     *   content?: string|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam>|null,
     *   isError?: bool|null,
     * }|ServerToolUseBlockParam|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name?: 'web_search',
     *   type?: 'server_tool_use',
     *   cacheControl?: CacheControlEphemeral|null,
     * }|WebSearchToolResultBlockParam|array{
     *   content: list<WebSearchResultBlockParam>|WebSearchToolRequestError,
     *   toolUseID: string,
     *   type?: 'web_search_tool_result',
     *   cacheControl?: CacheControlEphemeral|null,
     * }> $content
     * @param Role|value-of<Role> $role
     */
    public static function with(string|array $content, Role|string $role): self
    {
        $self = new self;

        $self['content'] = $content;
        $self['role'] = $role;

        return $self;
    }

    /**
     * @param string|list<TextBlockParam|array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
     * }|ImageBlockParam|array{
     *   source: Base64ImageSource|URLImageSource,
     *   type?: 'image',
     *   cacheControl?: CacheControlEphemeral|null,
     * }|DocumentBlockParam|array{
     *   source: Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource,
     *   type?: 'document',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: CitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * }|SearchResultBlockParam|array{
     *   content: list<TextBlockParam>,
     *   source: string,
     *   title: string,
     *   type?: 'search_result',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: CitationsConfigParam|null,
     * }|ThinkingBlockParam|array{
     *   signature: string, thinking: string, type?: 'thinking'
     * }|RedactedThinkingBlockParam|array{
     *   data: string, type?: 'redacted_thinking'
     * }|ToolUseBlockParam|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   type?: 'tool_use',
     *   cacheControl?: CacheControlEphemeral|null,
     * }|ToolResultBlockParam|array{
     *   toolUseID: string,
     *   type?: 'tool_result',
     *   cacheControl?: CacheControlEphemeral|null,
     *   content?: string|list<TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam>|null,
     *   isError?: bool|null,
     * }|ServerToolUseBlockParam|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name?: 'web_search',
     *   type?: 'server_tool_use',
     *   cacheControl?: CacheControlEphemeral|null,
     * }|WebSearchToolResultBlockParam|array{
     *   content: list<WebSearchResultBlockParam>|WebSearchToolRequestError,
     *   toolUseID: string,
     *   type?: 'web_search_tool_result',
     *   cacheControl?: CacheControlEphemeral|null,
     * }> $content
     */
    public function withContent(string|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param Role|value-of<Role> $role
     */
    public function withRole(Role|string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }
}
