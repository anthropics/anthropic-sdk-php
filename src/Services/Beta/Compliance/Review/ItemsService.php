<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Compliance\Review;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewItem;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Compliance\Review\ItemsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ItemsService implements ItemsContract
{
    /**
     * @api
     */
    public ItemsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ItemsRawService($client);
    }

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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Optional header to specify the beta version(s) you want to use.
     * @param string $userProfileID The ID of the user profile that the message was recorded with (`uprof_...`). Send it for a message recorded with a user profile, and leave it out for a message recorded with none.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $itemID,
        ?array $betas = null,
        ?string $userProfileID = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaComplianceReviewItem {
        $params = Util::removeNulls(
            ['betas' => $betas, 'userProfileID' => $userProfileID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($itemID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
