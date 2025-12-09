<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaMessageParam\Content;
use Anthropic\Beta\Messages\BetaMessageParam\Role;
use Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Name;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMessageParamShape = array{
 *   content: string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaToolSearchToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam>,
 *   role: value-of<Role>,
 * }
 */
final class BetaMessageParam implements BaseModel
{
    /** @use SdkModel<BetaMessageParamShape> */
    use SdkModel;

    /**
     * @var string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaToolSearchToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam> $content
     */
    #[Required(union: Content::class)]
    public string|array $content;

    /** @var value-of<Role> $role */
    #[Required(enum: Role::class)]
    public string $role;

    /**
     * `new BetaMessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMessageParam::with(content: ..., role: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMessageParam)->withContent(...)->withRole(...)
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
     * @param string|list<BetaTextBlockParam|array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
     * }|BetaImageBlockParam|array{
     *   source: BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource,
     *   type?: 'image',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaRequestDocumentBlock|array{
     *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource,
     *   type?: 'document',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * }|BetaSearchResultBlockParam|array{
     *   content: list<BetaTextBlockParam>,
     *   source: string,
     *   title: string,
     *   type?: 'search_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     * }|BetaThinkingBlockParam|array{
     *   signature: string, thinking: string, type?: 'thinking'
     * }|BetaRedactedThinkingBlockParam|array{
     *   data: string, type?: 'redacted_thinking'
     * }|BetaToolUseBlockParam|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   type?: 'tool_use',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   caller?: BetaDirectCaller|BetaServerToolCaller|null,
     * }|BetaToolResultBlockParam|array{
     *   toolUseID: string,
     *   type?: 'tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   content?: string|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam|BetaRequestDocumentBlock|BetaToolReferenceBlockParam>|null,
     *   isError?: bool|null,
     * }|BetaServerToolUseBlockParam|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: value-of<Name>,
     *   type?: 'server_tool_use',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   caller?: BetaDirectCaller|BetaServerToolCaller|null,
     * }|BetaWebSearchToolResultBlockParam|array{
     *   content: list<BetaWebSearchResultBlockParam>|BetaWebSearchToolRequestError,
     *   toolUseID: string,
     *   type?: 'web_search_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaWebFetchToolResultBlockParam|array{
     *   content: BetaWebFetchToolResultErrorBlockParam|BetaWebFetchBlockParam,
     *   toolUseID: string,
     *   type?: 'web_fetch_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaCodeExecutionToolResultBlockParam|array{
     *   content: BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam,
     *   toolUseID: string,
     *   type?: 'code_execution_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaBashCodeExecutionToolResultBlockParam|array{
     *   content: BetaBashCodeExecutionToolResultErrorParam|BetaBashCodeExecutionResultBlockParam,
     *   toolUseID: string,
     *   type?: 'bash_code_execution_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaTextEditorCodeExecutionToolResultBlockParam|array{
     *   content: BetaTextEditorCodeExecutionToolResultErrorParam|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam,
     *   toolUseID: string,
     *   type?: 'text_editor_code_execution_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaToolSearchToolResultBlockParam|array{
     *   content: BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam,
     *   toolUseID: string,
     *   type?: 'tool_search_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaMCPToolUseBlockParam|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   serverName: string,
     *   type?: 'mcp_tool_use',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaRequestMCPToolResultBlockParam|array{
     *   toolUseID: string,
     *   type?: 'mcp_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   content?: string|list<BetaTextBlockParam>|null,
     *   isError?: bool|null,
     * }|BetaContainerUploadBlockParam|array{
     *   fileID: string,
     *   type?: 'container_upload',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }> $content
     * @param Role|value-of<Role> $role
     */
    public static function with(string|array $content, Role|string $role): self
    {
        $obj = new self;

        $obj['content'] = $content;
        $obj['role'] = $role;

        return $obj;
    }

    /**
     * @param string|list<BetaTextBlockParam|array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
     * }|BetaImageBlockParam|array{
     *   source: BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource,
     *   type?: 'image',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaRequestDocumentBlock|array{
     *   source: BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource,
     *   type?: 'document',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     *   context?: string|null,
     *   title?: string|null,
     * }|BetaSearchResultBlockParam|array{
     *   content: list<BetaTextBlockParam>,
     *   source: string,
     *   title: string,
     *   type?: 'search_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   citations?: BetaCitationsConfigParam|null,
     * }|BetaThinkingBlockParam|array{
     *   signature: string, thinking: string, type?: 'thinking'
     * }|BetaRedactedThinkingBlockParam|array{
     *   data: string, type?: 'redacted_thinking'
     * }|BetaToolUseBlockParam|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   type?: 'tool_use',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   caller?: BetaDirectCaller|BetaServerToolCaller|null,
     * }|BetaToolResultBlockParam|array{
     *   toolUseID: string,
     *   type?: 'tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   content?: string|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam|BetaRequestDocumentBlock|BetaToolReferenceBlockParam>|null,
     *   isError?: bool|null,
     * }|BetaServerToolUseBlockParam|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: value-of<Name>,
     *   type?: 'server_tool_use',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   caller?: BetaDirectCaller|BetaServerToolCaller|null,
     * }|BetaWebSearchToolResultBlockParam|array{
     *   content: list<BetaWebSearchResultBlockParam>|BetaWebSearchToolRequestError,
     *   toolUseID: string,
     *   type?: 'web_search_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaWebFetchToolResultBlockParam|array{
     *   content: BetaWebFetchToolResultErrorBlockParam|BetaWebFetchBlockParam,
     *   toolUseID: string,
     *   type?: 'web_fetch_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaCodeExecutionToolResultBlockParam|array{
     *   content: BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam,
     *   toolUseID: string,
     *   type?: 'code_execution_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaBashCodeExecutionToolResultBlockParam|array{
     *   content: BetaBashCodeExecutionToolResultErrorParam|BetaBashCodeExecutionResultBlockParam,
     *   toolUseID: string,
     *   type?: 'bash_code_execution_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaTextEditorCodeExecutionToolResultBlockParam|array{
     *   content: BetaTextEditorCodeExecutionToolResultErrorParam|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam,
     *   toolUseID: string,
     *   type?: 'text_editor_code_execution_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaToolSearchToolResultBlockParam|array{
     *   content: BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam,
     *   toolUseID: string,
     *   type?: 'tool_search_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaMCPToolUseBlockParam|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   serverName: string,
     *   type?: 'mcp_tool_use',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }|BetaRequestMCPToolResultBlockParam|array{
     *   toolUseID: string,
     *   type?: 'mcp_tool_result',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     *   content?: string|list<BetaTextBlockParam>|null,
     *   isError?: bool|null,
     * }|BetaContainerUploadBlockParam|array{
     *   fileID: string,
     *   type?: 'container_upload',
     *   cacheControl?: BetaCacheControlEphemeral|null,
     * }> $content
     */
    public function withContent(string|array $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    /**
     * @param Role|value-of<Role> $role
     */
    public function withRole(Role|string $role): self
    {
        $obj = clone $this;
        $obj['role'] = $role;

        return $obj;
    }
}
