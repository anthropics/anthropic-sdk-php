<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Which sources contribute URLs the web_fetch tool may fetch. A key that is null was not set and allows every URL from that source.
 *
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceToolFilterShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceToolFilter
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceUserInputShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceUserInput
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceToolFilterVariants from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceToolFilter
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceUserInputVariants from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceUserInput
 *
 * @phpstan-type BetaManagedAgentsWebFetchURLSourcesShape = array{
 *   clientToolResults: BetaManagedAgentsWebFetchURLSourceToolFilterShape|null,
 *   serverToolResults: BetaManagedAgentsWebFetchURLSourceToolFilterShape|null,
 *   userInput: BetaManagedAgentsWebFetchURLSourceUserInputShape|null,
 * }
 */
final class BetaManagedAgentsWebFetchURLSources implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWebFetchURLSourcesShape> */
    use SdkModel;

    /**
     * Which custom tools' results contribute URLs that may be fetched. Null when not set, which allows every custom tool's results.
     *
     * @var BetaManagedAgentsWebFetchURLSourceToolFilterVariants|null $clientToolResults
     */
    #[Required(
        'client_tool_results',
        union: BetaManagedAgentsWebFetchURLSourceToolFilter::class,
    )]
    public BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|null $clientToolResults;

    /**
     * Which of the web_search and web_fetch tools' results contribute URLs that may be fetched. Null when not set, which allows both.
     *
     * @var BetaManagedAgentsWebFetchURLSourceToolFilterVariants|null $serverToolResults
     */
    #[Required(
        'server_tool_results',
        union: BetaManagedAgentsWebFetchURLSourceToolFilter::class,
    )]
    public BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|null $serverToolResults;

    /**
     * Whether URLs in the text of user messages may be fetched. Null when not set, which allows them.
     *
     * @var BetaManagedAgentsWebFetchURLSourceUserInputVariants|null $userInput
     */
    #[Required(
        'user_input',
        union: BetaManagedAgentsWebFetchURLSourceUserInput::class
    )]
    public BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|null $userInput;

    /**
     * `new BetaManagedAgentsWebFetchURLSources()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsWebFetchURLSources::with(
     *   clientToolResults: ..., serverToolResults: ..., userInput: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsWebFetchURLSources())
     *   ->withClientToolResults(...)
     *   ->withServerToolResults(...)
     *   ->withUserInput(...)
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
     * @param BetaManagedAgentsWebFetchURLSourceToolFilterShape|null $clientToolResults
     * @param BetaManagedAgentsWebFetchURLSourceToolFilterShape|null $serverToolResults
     * @param BetaManagedAgentsWebFetchURLSourceUserInputShape|null $userInput
     */
    public static function with(
        BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|null $clientToolResults,
        BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|null $serverToolResults,
        BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|null $userInput,
    ): self {
        $self = new self;

        $self['clientToolResults'] = $clientToolResults;
        $self['serverToolResults'] = $serverToolResults;
        $self['userInput'] = $userInput;

        return $self;
    }

    /**
     * Which custom tools' results contribute URLs that may be fetched. Null when not set, which allows every custom tool's results.
     *
     * @param BetaManagedAgentsWebFetchURLSourceToolFilterShape|null $clientToolResults
     */
    public function withClientToolResults(
        BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|null $clientToolResults,
    ): self {
        $self = clone $this;
        $self['clientToolResults'] = $clientToolResults;

        return $self;
    }

    /**
     * Which of the web_search and web_fetch tools' results contribute URLs that may be fetched. Null when not set, which allows both.
     *
     * @param BetaManagedAgentsWebFetchURLSourceToolFilterShape|null $serverToolResults
     */
    public function withServerToolResults(
        BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|null $serverToolResults,
    ): self {
        $self = clone $this;
        $self['serverToolResults'] = $serverToolResults;

        return $self;
    }

    /**
     * Whether URLs in the text of user messages may be fetched. Null when not set, which allows them.
     *
     * @param BetaManagedAgentsWebFetchURLSourceUserInputShape|null $userInput
     */
    public function withUserInput(
        BetaManagedAgentsWebFetchURLSourceAll|array|BetaManagedAgentsWebFetchURLSourceNone|null $userInput,
    ): self {
        $self = clone $this;
        $self['userInput'] = $userInput;

        return $self;
    }
}
