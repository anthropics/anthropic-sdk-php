<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches\BatchCreateParams\Request\Params;

use Anthropic\Beta\Messages\BetaFallbackCreditTokenParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The `fallback_credit_token` from a prior refusal's `stop_details`.
 *
 * When a preceding request was refused and returned a `fallback_credit_token`,
 * pass that code here on the retry to have the retry's cache-creation tokens
 * for the prefix that was warm on the refused model billed at the cache-read
 * rate. Must be redeemed by the same organization and workspace, with the same
 * request body (optionally extended by one appended `assistant` message whose
 * content is the partial text — with any trailing whitespace stripped from
 * the final text block — and paired server-tool blocks streamed before the
 * refusal; the appended-assistant form is not available for requests with
 * `output_format` set or forced `tool_choice`), on an eligible fallback
 * model, on the same platform,
 * and within 5 minutes of the refusal; a mismatch is a 400. A token minted
 * mid-server-tool-loop whose partial content was continuable may only be
 * redeemed with the appended-assistant form — if an exact-body retry is
 * rejected with a 400 saying the token must be redeemed by continuing the
 * partial response, retry with the appended-assistant form instead.
 *
 * When the appended-assistant form is used on a model that otherwise disallows
 * assistant-turn prefill, this token also authorizes that one prefill.
 *
 * @phpstan-import-type BetaFallbackCreditTokenParamShape from \Anthropic\Beta\Messages\BetaFallbackCreditTokenParam
 *
 * @phpstan-type FallbackCreditTokenVariants = string|BetaFallbackCreditTokenParam
 * @phpstan-type FallbackCreditTokenShape = FallbackCreditTokenVariants|BetaFallbackCreditTokenParamShape
 */
final class FallbackCreditToken implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', BetaFallbackCreditTokenParam::class];
    }
}
