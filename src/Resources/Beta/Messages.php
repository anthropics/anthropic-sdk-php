<?php

declare(strict_types=1);

namespace Anthropic\Resources\Beta;

use Anthropic\Client;
use Anthropic\Contracts\Beta\MessagesContract;
use Anthropic\Core\Serde;
use Anthropic\Core\Util;
use Anthropic\Models\Beta\BetaCodeExecutionTool20250522;
use Anthropic\Models\Beta\BetaMessage;
use Anthropic\Models\Beta\BetaMessageParam;
use Anthropic\Models\Beta\BetaMessageTokensCount;
use Anthropic\Models\Beta\BetaMetadata;
use Anthropic\Models\Beta\BetaRequestMCPServerURLDefinition;
use Anthropic\Models\Beta\BetaTextBlockParam;
use Anthropic\Models\Beta\BetaThinkingConfigDisabled;
use Anthropic\Models\Beta\BetaThinkingConfigEnabled;
use Anthropic\Models\Beta\BetaTool;
use Anthropic\Models\Beta\BetaToolBash20241022;
use Anthropic\Models\Beta\BetaToolBash20250124;
use Anthropic\Models\Beta\BetaToolChoiceAny;
use Anthropic\Models\Beta\BetaToolChoiceAuto;
use Anthropic\Models\Beta\BetaToolChoiceNone;
use Anthropic\Models\Beta\BetaToolChoiceTool;
use Anthropic\Models\Beta\BetaToolComputerUse20241022;
use Anthropic\Models\Beta\BetaToolComputerUse20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20241022;
use Anthropic\Models\Beta\BetaToolTextEditor20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20250429;
use Anthropic\Models\Beta\BetaWebSearchTool20250305;
use Anthropic\Parameters\Beta\Messages\CountTokensParams;
use Anthropic\Parameters\Beta\Messages\CreateParams;
use Anthropic\RequestOptions;
use Anthropic\Resources\Beta\Messages\Batches;

class Messages implements MessagesContract
{
    public Batches $batches;

    public function __construct(protected Client $client)
    {
        $this->batches = new Batches($client);
    }

    /**
     * @param array{
     *   maxTokens?: int,
     *   messages?: list<BetaMessageParam>,
     *   model?: string|string,
     *   container?: string|null,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *   metadata?: BetaMetadata,
     *   serviceTier?: string,
     *   stopSequences?: list<string>,
     *   stream?: bool,
     *   system?: string|list<BetaTextBlockParam>,
     *   temperature?: float,
     *   thinking?: BetaThinkingConfigEnabled|BetaThinkingConfigDisabled,
     *   toolChoice?: BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone,
     *   tools?: list<BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305>,
     *   topK?: int,
     *   topP?: float,
     *   betas?: list<string|string>,
     * } $params
     */
    public function create(
        array $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessage {
        [$parsed, $options] = CreateParams::parseRequest($params, $requestOptions);
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
        return Serde::coerce(BetaMessage::class, value: $resp);
    }

    /**
     * @param array{
     *   messages?: list<BetaMessageParam>,
     *   model?: string|string,
     *   mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *   system?: string|list<BetaTextBlockParam>,
     *   thinking?: BetaThinkingConfigEnabled|BetaThinkingConfigDisabled,
     *   toolChoice?: BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone,
     *   tools?: list<BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305>,
     *   betas?: list<string|string>,
     * } $params
     */
    public function countTokens(
        array $params,
        ?RequestOptions $requestOptions = null
    ): BetaMessageTokensCount {
        [$parsed, $options] = CountTokensParams::parseRequest(
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
        return Serde::coerce(BetaMessageTokensCount::class, value: $resp);
    }
}
