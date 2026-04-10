<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Skills\SkillDeleteResponse;
use Anthropic\Beta\Skills\SkillGetResponse;
use Anthropic\Beta\Skills\SkillListResponse;
use Anthropic\Beta\Skills\SkillNewResponse;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\SkillsContract;
use Anthropic\Services\Beta\Skills\VersionsService;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class SkillsService implements SkillsContract
{
    /**
     * @api
     */
    public SkillsRawService $raw;

    /**
     * @api
     */
    public VersionsService $versions;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SkillsRawService($client);
        $this->versions = new VersionsService($client);
    }

    /**
     * @api
     *
     * Create Skill
     *
     * @param string|null $displayTitle Body param: Display title for the skill.
     *
     * This is a human-readable label that is not included in the prompt sent to the model.
     * @param list<string|FileParam>|null $files Body param: Files to upload for the skill.
     *
     * All files must be in the same top-level directory and must include a SKILL.md file at the root of that directory.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $displayTitle = null,
        ?array $files = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): SkillNewResponse {
        $params = Util::removeNulls(
            ['displayTitle' => $displayTitle, 'files' => $files, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get Skill
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $skillID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): SkillGetResponse {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($skillID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List Skills
     *
     * @param int $limit Query param: Number of results to return per page.
     *
     * Maximum value is 100. Defaults to 20.
     * @param string|null $page Query param: Pagination token for fetching a specific page of results.
     *
     * Pass the value from a previous response's `next_page` field to get the next page of results.
     * @param string|null $source Query param: Filter skills by source.
     *
     * If provided, only skills from the specified source will be returned:
     * * `"custom"`: only return user-created skills
     * * `"anthropic"`: only return Anthropic-created skills
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<SkillListResponse>
     *
     * @throws APIException
     */
    public function list(
        int $limit = 20,
        ?string $page = null,
        ?string $source = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'page' => $page,
                'source' => $source,
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
     * Delete Skill
     *
     * @param string $skillID Unique identifier for the skill.
     *
     * The format and length of IDs may change over time.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $skillID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): SkillDeleteResponse {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($skillID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
