<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaWebFetchURLSources\ClientToolResults;
use Anthropic\Beta\Messages\BetaWebFetchURLSources\ServerToolResults;
use Anthropic\Beta\Messages\BetaWebFetchURLSources\UserInput;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Which sources contribute to the set of URLs web fetch may fetch.
 *
 * Each key is a tagged variant: ``user_input`` is ``all`` or ``none``; the
 * two tool filters are ``all``, ``none``, ``only`` (only the named tools'
 * results) or ``except`` (every result but the named tools'). A named tool
 * must be declared in this request's ``tools[]``.
 *
 * @phpstan-import-type ClientToolResultsVariants from \Anthropic\Beta\Messages\BetaWebFetchURLSources\ClientToolResults
 * @phpstan-import-type ServerToolResultsVariants from \Anthropic\Beta\Messages\BetaWebFetchURLSources\ServerToolResults
 * @phpstan-import-type UserInputVariants from \Anthropic\Beta\Messages\BetaWebFetchURLSources\UserInput
 * @phpstan-import-type ClientToolResultsShape from \Anthropic\Beta\Messages\BetaWebFetchURLSources\ClientToolResults
 * @phpstan-import-type ServerToolResultsShape from \Anthropic\Beta\Messages\BetaWebFetchURLSources\ServerToolResults
 * @phpstan-import-type UserInputShape from \Anthropic\Beta\Messages\BetaWebFetchURLSources\UserInput
 *
 * @phpstan-type BetaWebFetchURLSourcesShape = array{
 *   clientToolResults?: ClientToolResultsShape|null,
 *   serverToolResults?: ServerToolResultsShape|null,
 *   userInput?: UserInputShape|null,
 * }
 */
final class BetaWebFetchURLSources implements BaseModel
{
    /** @use SdkModel<BetaWebFetchURLSourcesShape> */
    use SdkModel;

    /**
     * Which client tools' results contribute fetchable URLs: "all", "none", or an only or except list of client tool names from tools[].
     *
     * @var ClientToolResultsVariants|null $clientToolResults
     */
    #[Optional('client_tool_results', union: ClientToolResults::class)]
    public BetaWebFetchURLSourceAll|BetaWebFetchURLSourceNone|BetaWebFetchURLSourceOnly|BetaWebFetchURLSourceExcept|null $clientToolResults;

    /**
     * Which server tools' results contribute fetchable URLs: "all", "none", or an only or except list of server tool names from tools[]; only web_search and web_fetch results ever contribute.
     *
     * @var ServerToolResultsVariants|null $serverToolResults
     */
    #[Optional('server_tool_results', union: ServerToolResults::class)]
    public BetaWebFetchURLSourceAll|BetaWebFetchURLSourceNone|BetaWebFetchURLSourceOnly|BetaWebFetchURLSourceExcept|null $serverToolResults;

    /**
     * Whether URLs in user messages are fetchable: "all" or "none".
     *
     * @var UserInputVariants|null $userInput
     */
    #[Optional('user_input', union: UserInput::class)]
    public BetaWebFetchURLSourceAll|BetaWebFetchURLSourceNone|null $userInput;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ClientToolResultsShape|null $clientToolResults
     * @param ServerToolResultsShape|null $serverToolResults
     * @param UserInputShape|null $userInput
     */
    public static function with(
        BetaWebFetchURLSourceAll|array|BetaWebFetchURLSourceNone|BetaWebFetchURLSourceOnly|BetaWebFetchURLSourceExcept|null $clientToolResults = null,
        BetaWebFetchURLSourceAll|array|BetaWebFetchURLSourceNone|BetaWebFetchURLSourceOnly|BetaWebFetchURLSourceExcept|null $serverToolResults = null,
        BetaWebFetchURLSourceAll|array|BetaWebFetchURLSourceNone|null $userInput = null,
    ): self {
        $self = new self;

        null !== $clientToolResults && $self['clientToolResults'] = $clientToolResults;
        null !== $serverToolResults && $self['serverToolResults'] = $serverToolResults;
        null !== $userInput && $self['userInput'] = $userInput;

        return $self;
    }

    /**
     * Which client tools' results contribute fetchable URLs: "all", "none", or an only or except list of client tool names from tools[].
     *
     * @param ClientToolResultsShape $clientToolResults
     */
    public function withClientToolResults(
        BetaWebFetchURLSourceAll|array|BetaWebFetchURLSourceNone|BetaWebFetchURLSourceOnly|BetaWebFetchURLSourceExcept $clientToolResults,
    ): self {
        $self = clone $this;
        $self['clientToolResults'] = $clientToolResults;

        return $self;
    }

    /**
     * Which server tools' results contribute fetchable URLs: "all", "none", or an only or except list of server tool names from tools[]; only web_search and web_fetch results ever contribute.
     *
     * @param ServerToolResultsShape $serverToolResults
     */
    public function withServerToolResults(
        BetaWebFetchURLSourceAll|array|BetaWebFetchURLSourceNone|BetaWebFetchURLSourceOnly|BetaWebFetchURLSourceExcept $serverToolResults,
    ): self {
        $self = clone $this;
        $self['serverToolResults'] = $serverToolResults;

        return $self;
    }

    /**
     * Whether URLs in user messages are fetchable: "all" or "none".
     *
     * @param UserInputShape $userInput
     */
    public function withUserInput(
        BetaWebFetchURLSourceAll|array|BetaWebFetchURLSourceNone $userInput
    ): self {
        $self = clone $this;
        $self['userInput'] = $userInput;

        return $self;
    }
}
