<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Dreams\BetaDream;
use Anthropic\Beta\Dreams\BetaDreamModelConfigParam;
use Anthropic\Beta\Dreams\BetaDreamStatus;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\DreamsContract;

/**
 * @phpstan-import-type BetaDreamInputShape from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Dreams\DreamCreateParams\Model
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class DreamsService implements DreamsContract
{
    /**
     * @api
     */
    public DreamsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new DreamsRawService($client);
    }

    /**
     * @api
     *
     * Create a Dream
     *
     * @param list<BetaDreamInputShape> $inputs Body param
     * @param ModelShape $model body param: Model identifier and configuration applied to every pipeline stage
     * @param string|null $instructions Body param
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $inputs,
        string|BetaDreamModelConfigParam|array $model,
        ?string $instructions = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDream {
        $params = Util::removeNulls(
            [
                'inputs' => $inputs,
                'model' => $model,
                'instructions' => $instructions,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get a Dream
     *
     * @param string $dreamID Path parameter dream_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $dreamID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDream {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($dreamID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List Dreams
     *
     * @param \DateTimeInterface $createdAtGt Query param: Return dreams with `created_at` strictly after this timestamp (exclusive lower bound, RFC 3339). Unset applies no lower bound.
     * @param \DateTimeInterface $createdAtLt Query param: Return dreams with `created_at` strictly before this timestamp (exclusive upper bound, RFC 3339). Unset applies no upper bound.
     * @param bool $includeArchived Query param: Query parameter for include_archived
     * @param int $limit Query param: Query parameter for limit
     * @param string $page Query param: Query parameter for page
     * @param list<BetaDreamStatus|value-of<BetaDreamStatus>> $statuses Query param: Filter by lifecycle status. Repeat the parameter to match any of multiple statuses. Empty applies no status filter.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaDream>
     *
     * @throws APIException
     */
    public function list(
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $statuses = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'createdAtGt' => $createdAtGt,
                'createdAtLt' => $createdAtLt,
                'includeArchived' => $includeArchived,
                'limit' => $limit,
                'page' => $page,
                'statuses' => $statuses,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Archive a Dream
     *
     * @param string $dreamID Path parameter dream_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $dreamID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDream {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($dreamID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Cancel a Dream
     *
     * @param string $dreamID Path parameter dream_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function cancel(
        string $dreamID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDream {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->cancel($dreamID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
