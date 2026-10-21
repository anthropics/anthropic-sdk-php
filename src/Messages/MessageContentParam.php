<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type ContentBlockParamShape from \Anthropic\Messages\ContentBlockParam
 *
 * @phpstan-type MessageContentParamVariants = string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam|WebFetchToolResultBlockParam|CodeExecutionToolResultBlockParam|BashCodeExecutionToolResultBlockParam|TextEditorCodeExecutionToolResultBlockParam|ToolSearchToolResultBlockParam|ContainerUploadBlockParam>
 * @phpstan-type MessageContentParamShape = MessageContentParamVariants|list<ContentBlockParamShape>
 */
final class MessageContentParam implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(ContentBlockParam::class)];
    }
}
