<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\CompletionsContract;
use Anthropic\Core\Conversion;
use Anthropic\Core\Util;
use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Completion;
use Anthropic\Models\CompletionCreateParams;
use Anthropic\Models\Metadata;
use Anthropic\Models\Model\UnionMember0;
use Anthropic\RequestOptions;

final class Completions implements CompletionsContract
{
    public function __construct(private Client $client) {}

    /**
     * [Legacy] Create a Text Completion.
     *
     * The Text Completions API is a legacy API. We recommend using the [Messages API](https://docs.anthropic.com/en/api/messages) going forward.
     *
     * Future models and features will not be compatible with Text Completions. See our [migration guide](https://docs.anthropic.com/en/api/migrating-from-text-completions-to-messages) for guidance in migrating from Text Completions to Messages.
     *
     * @param array{
     *   maxTokensToSample: int,
     *   model: string|UnionMember0::*,
     *   prompt: string,
     *   metadata?: Metadata,
     *   stopSequences?: list<string>,
     *   temperature?: float,
     *   topK?: int,
     *   topP?: float,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * }|CompletionCreateParams $params
     */
    public function create(
        array|CompletionCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): Completion {
        [$parsed, $options] = CompletionCreateParams::parseRequest(
            $params,
            $requestOptions
        );
        $header_params = ['betas' => 'anthropic-beta'];
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/complete',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_keys($header_params)),
                $header_params
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: array_merge(['timeout' => 600], $options),
        );

        // @phpstan-ignore-next-line;
        return Conversion::coerce(Completion::class, value: $resp);
    }
}
