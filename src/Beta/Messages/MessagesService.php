<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Messages\Batches\BatchesService;
use Anthropic\Beta\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Client;
use Anthropic\Contracts\Beta\MessagesContract;
use Anthropic\Core\Conversion;
use Anthropic\Core\Util;
use Anthropic\Messages\Model;
use Anthropic\RequestOptions;

final class MessagesService implements MessagesContract
{
    public BatchesService $batches;

    public function __construct(private Client $client)
    {
        $this->batches = new BatchesService($this->client);
    }

    /**
     * Send a structured list of input messages with text and/or image content, and the model will generate the next message in the conversation.
     *
     * The Messages API can be used for either single queries or stateless multi-turn conversations.
     *
     * Learn more about the Messages API in our [user guide](/en/docs/initial-setup)
     *
     * @param array{
     *   maxTokens: int,
     *   messages: list<BetaMessageParam>,
     *   model: Model::*|string,
     *   container?: null|string,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *   metadata?: BetaMetadata,
     *   serviceTier?: ServiceTier::*,
     *   stopSequences?: list<string>,
     *   system?: list<BetaTextBlockParam>|string,
     *   temperature?: float,
     *   thinking?: BetaThinkingConfigDisabled|BetaThinkingConfigEnabled,
     *   toolChoice?: BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool,
     *   tools?: list<BetaCodeExecutionTool20250522|BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305>,
     *   topK?: int,
     *   topP?: float,
     *   anthropicBeta?: list<AnthropicBeta::*|string>,
     * }|MessageCreateParams $params
     */
    public function create(
        array|MessageCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessage {
        [$parsed, $options] = MessageCreateParams::parseRequest(
            $params,
            $requestOptions
        );
        $header_params = ['betas' => 'anthropic-beta'];
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_keys($header_params)),
                $header_params
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: array_merge(['timeout' => 600], $options),
        );

        // @phpstan-ignore-next-line;
        return Conversion::coerce(BetaMessage::class, value: $resp);
    }

    /**
     * Count the number of tokens in a Message.
     *
     * The Token Count API can be used to count the number of tokens in a Message, including tools, images, and documents, without creating it.
     *
     * Learn more about token counting in our [user guide](/en/docs/build-with-claude/token-counting)
     *
     * @param array{
     *   messages: list<BetaMessageParam>,
     *   model: Model::*|string,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *   system?: list<BetaTextBlockParam>|string,
     *   thinking?: BetaThinkingConfigDisabled|BetaThinkingConfigEnabled,
     *   toolChoice?: BetaToolChoiceAny|BetaToolChoiceAuto|BetaToolChoiceNone|BetaToolChoiceTool,
     *   tools?: list<BetaCodeExecutionTool20250522|BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305>,
     *   anthropicBeta?: list<AnthropicBeta::*|string>,
     * }|MessageCountTokensParams $params
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageTokensCount {
        [$parsed, $options] = MessageCountTokensParams::parseRequest(
            $params,
            $requestOptions
        );
        $header_params = ['betas' => 'anthropic-beta'];
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages/count_tokens?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_keys($header_params)),
                $header_params
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Conversion::coerce(BetaMessageTokensCount::class, value: $resp);
    }
}
