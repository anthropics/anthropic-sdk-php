<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaUsage implements BaseModel
{
    use Model;

    #[Api('cache_creation')]
    public BetaCacheCreation $cacheCreation;

    #[Api('cache_creation_input_tokens')]
    public ?int $cacheCreationInputTokens;

    #[Api('cache_read_input_tokens')]
    public ?int $cacheReadInputTokens;

    #[Api('input_tokens')]
    public int $inputTokens;

    #[Api('output_tokens')]
    public int $outputTokens;

    #[Api('server_tool_use')]
    public BetaServerToolUsage $serverToolUse;

    #[Api('service_tier')]
    public ?string $serviceTier;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param BetaCacheCreation   $cacheCreation            `required`
     * @param null|int            $cacheCreationInputTokens `required`
     * @param null|int            $cacheReadInputTokens     `required`
     * @param int                 $inputTokens              `required`
     * @param int                 $outputTokens             `required`
     * @param BetaServerToolUsage $serverToolUse            `required`
     * @param null|string         $serviceTier              `required`
     */
    final public function __construct(
        $cacheCreation,
        $cacheCreationInputTokens,
        $cacheReadInputTokens,
        $inputTokens,
        $outputTokens,
        $serverToolUse,
        $serviceTier,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaUsage::_loadMetadata();
