<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type tool_text_editor20250728 = array{
 *   name: string,
 *   type: string,
 *   cacheControl?: CacheControlEphemeral|null,
 *   maxCharacters?: int|null,
 * }
 */
final class ToolTextEditor20250728 implements BaseModel
{
    /** @use SdkModel<tool_text_editor20250728> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    #[Api]
    public string $name = 'str_replace_based_edit_tool';

    #[Api]
    public string $type = 'text_editor_20250728';

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', nullable: true, optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Maximum number of characters to display when viewing a file. If not specified, defaults to displaying the full file.
     */
    #[Api('max_characters', nullable: true, optional: true)]
    public ?int $maxCharacters;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?CacheControlEphemeral $cacheControl = null,
        ?int $maxCharacters = null
    ): self {
        $obj = new self;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $maxCharacters && $obj->maxCharacters = $maxCharacters;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(?CacheControlEphemeral $cacheControl): self
    {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    /**
     * Maximum number of characters to display when viewing a file. If not specified, defaults to displaying the full file.
     */
    public function withMaxCharacters(?int $maxCharacters): self
    {
        $obj = clone $this;
        $obj->maxCharacters = $maxCharacters;

        return $obj;
    }
}
