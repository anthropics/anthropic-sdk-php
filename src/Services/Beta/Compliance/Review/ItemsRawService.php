<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Compliance\Review;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewItem;
use Anthropic\Beta\Compliance\Review\Items\ItemRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Compliance\Review\ItemsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ItemsRawService implements ItemsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Read one message that Anthropic flagged for your organization to review, with its request and response.
     *
     * A message that the API key can't read, or that isn't flagged, returns the same 404 as one that doesn't exist. For a message recorded with a user profile, send that profile's ID in the `anthropic-user-profile-id` header. A flagged message can also return 404 if it belongs to another organization than the key's own, or to your end customer's user profile or Workspace.
     *
     * If your encryption key or storage bucket refuses the read, the API returns a 400 with `cmek_key_disabled`, `storage_bucket_unreadable` or `customer_storage_refusal_unattributed` in `error.details.error_code`.
     *
     * The API key must have the `read:compliance_review_items`, `read:compliance_user_data` or `read:org_audit` scope. A key of an organization with no parent organization must have `read:compliance_review_items`.
     *
     * @param string $itemID The ID of the item. For a message, its ID as the client received it or as a review case lists it, such as `msg_...`.
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   userProfileID?: string,
     * }|ItemRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaComplianceReviewItem>
     *
     * @throws APIException
     */
    public function retrieve(
        string $itemID,
        array|ItemRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ItemRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/compliance/review/items/%1$s', $itemID],
            headers: Util::array_transform_keys(
                $parsed,
                [
                    'betas' => 'anthropic-beta',
                    'userProfileID' => 'anthropic-user-profile-id',
                ],
            ),
            options: $options->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.compliance.review.items.retrieve',
                route: '/v1/compliance/review/items/{item_id}',
                attributes: ['anthropic.compliance.review.item.id' => $itemID],
            )),
            convert: BetaComplianceReviewItem::class,
        );
    }
}
