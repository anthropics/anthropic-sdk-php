<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Which sources contribute URLs the web_fetch tool may fetch. When web_fetch is limited to URLs the conversation has already shown the model (in a user message, a custom tool's result, or an earlier web_search or web_fetch result), each key narrows one of those sources and defaults to "all". Setting all three keys to "none" is rejected.
 *
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceToolFilterParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceToolFilterParams
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceUserInputParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceUserInputParams
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceToolFilterParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceToolFilterParams
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceUserInputParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceUserInputParams
 *
 * @phpstan-type BetaManagedAgentsWebFetchURLSourcesParamsShape = array{
 *   clientToolResults?: BetaManagedAgentsWebFetchURLSourceToolFilterParamsShape|null,
 *   serverToolResults?: BetaManagedAgentsWebFetchURLSourceToolFilterParamsShape|null,
 *   userInput?: BetaManagedAgentsWebFetchURLSourceUserInputParamsShape|null,
 * }
 */
final class BetaManagedAgentsWebFetchURLSourcesParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWebFetchURLSourcesParamsShape> */
    use SdkModel;

    /**
     * Which custom tools' results contribute URLs that may be fetched: "all" (the default), "none", or an only or except list. Each name in a list must be a custom tool in the same tools array.
     *
     * @var BetaManagedAgentsWebFetchURLSourceToolFilterParamsVariants|null $clientToolResults
     */
    #[Optional(
        'client_tool_results',
        union: BetaManagedAgentsWebFetchURLSourceToolFilterParams::class,
        nullable: true,
    )]
    public BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|string|null $clientToolResults;

    /**
     * Which of the web_search and web_fetch tools' results contribute URLs that may be fetched: "all" (the default), "none", or an only or except list. Each name in a list must be "web_search" or "web_fetch".
     *
     * @var BetaManagedAgentsWebFetchURLSourceToolFilterParamsVariants|null $serverToolResults
     */
    #[Optional(
        'server_tool_results',
        union: BetaManagedAgentsWebFetchURLSourceToolFilterParams::class,
        nullable: true,
    )]
    public BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|string|null $serverToolResults;

    /**
     * Whether URLs in the text of user messages may be fetched: "all" (the default) or "none".
     *
     * @var BetaManagedAgentsWebFetchURLSourceUserInputParamsVariants|null $userInput
     */
    #[Optional(
        'user_input',
        union: BetaManagedAgentsWebFetchURLSourceUserInputParams::class,
        nullable: true,
    )]
    public BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|string|null $userInput;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaManagedAgentsWebFetchURLSourceToolFilterParamsShape|null $clientToolResults
     * @param BetaManagedAgentsWebFetchURLSourceToolFilterParamsShape|null $serverToolResults
     * @param BetaManagedAgentsWebFetchURLSourceUserInputParamsShape|null $userInput
     */
    public static function with(
        BetaManagedAgentsWebFetchURLSourceShorthand|BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|string|null $clientToolResults = null,
        BetaManagedAgentsWebFetchURLSourceShorthand|BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|string|null $serverToolResults = null,
        BetaManagedAgentsWebFetchURLSourceShorthand|BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|string|null $userInput = null,
    ): self {
        $self = new self;

        null !== $clientToolResults && $self['clientToolResults'] = $clientToolResults;
        null !== $serverToolResults && $self['serverToolResults'] = $serverToolResults;
        null !== $userInput && $self['userInput'] = $userInput;

        return $self;
    }

    /**
     * Which custom tools' results contribute URLs that may be fetched: "all" (the default), "none", or an only or except list. Each name in a list must be a custom tool in the same tools array.
     *
     * @param BetaManagedAgentsWebFetchURLSourceToolFilterParamsShape|null $clientToolResults
     */
    public function withClientToolResults(
        BetaManagedAgentsWebFetchURLSourceShorthand|BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|string|null $clientToolResults,
    ): self {
        $self = clone $this;
        $self['clientToolResults'] = $clientToolResults;

        return $self;
    }

    /**
     * Which of the web_search and web_fetch tools' results contribute URLs that may be fetched: "all" (the default), "none", or an only or except list. Each name in a list must be "web_search" or "web_fetch".
     *
     * @param BetaManagedAgentsWebFetchURLSourceToolFilterParamsShape|null $serverToolResults
     */
    public function withServerToolResults(
        BetaManagedAgentsWebFetchURLSourceShorthand|BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|string|null $serverToolResults,
    ): self {
        $self = clone $this;
        $self['serverToolResults'] = $serverToolResults;

        return $self;
    }

    /**
     * Whether URLs in the text of user messages may be fetched: "all" (the default) or "none".
     *
     * @param BetaManagedAgentsWebFetchURLSourceUserInputParamsShape|null $userInput
     */
    public function withUserInput(
        BetaManagedAgentsWebFetchURLSourceShorthand|BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|string|null $userInput,
    ): self {
        $self = clone $this;
        $self['userInput'] = $userInput;

        return $self;
    }
}
