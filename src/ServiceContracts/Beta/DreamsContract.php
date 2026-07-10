<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Dreams\BetaDream;
use Anthropic\Beta\Dreams\BetaDreamModelConfigParam;
use Anthropic\Beta\Dreams\BetaDreamStatus;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type BetaDreamInputShape from \Anthropic\Beta\Dreams\BetaDreamInput
 * @phpstan-import-type ModelShape from \Anthropic\Beta\Dreams\DreamCreateParams\Model
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface DreamsContract
{
    /**
     * @api
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
    ): BetaDream;

    /**
     * @api
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
    ): BetaDream;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): BetaDream;

    /**
     * @api
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
    ): BetaDream;
}
