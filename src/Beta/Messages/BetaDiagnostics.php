<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaDiagnostics\CacheMissReason;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Response envelope for request-level diagnostics. Present (possibly
 * null) whenever the caller supplied `diagnostics` on the request.
 *
 * @phpstan-import-type CacheMissReasonVariants from \Anthropic\Beta\Messages\BetaDiagnostics\CacheMissReason
 * @phpstan-import-type CacheMissReasonShape from \Anthropic\Beta\Messages\BetaDiagnostics\CacheMissReason
 *
 * @phpstan-type BetaDiagnosticsShape = array{
 *   cacheMissReason: CacheMissReasonShape|null
 * }
 */
final class BetaDiagnostics implements BaseModel
{
    /** @use SdkModel<BetaDiagnosticsShape> */
    use SdkModel;

    /**
     * Explains why the prompt cache could not fully reuse the prefix from the request identified by `diagnostics.previous_message_id`. `null` means diagnosis is still pending — the response was serialized before the background comparison completed.
     *
     * @var CacheMissReasonVariants|null $cacheMissReason
     */
    #[Required('cache_miss_reason', union: CacheMissReason::class)]
    public BetaCacheMissModelChanged|BetaCacheMissSystemChanged|BetaCacheMissToolsChanged|BetaCacheMissMessagesChanged|BetaCacheMissPreviousMessageNotFound|BetaCacheMissUnavailable|null $cacheMissReason;

    /**
     * `new BetaDiagnostics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDiagnostics::with(cacheMissReason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDiagnostics)->withCacheMissReason(...)
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
     * @param CacheMissReasonShape|null $cacheMissReason
     */
    public static function with(
        BetaCacheMissModelChanged|array|BetaCacheMissSystemChanged|BetaCacheMissToolsChanged|BetaCacheMissMessagesChanged|BetaCacheMissPreviousMessageNotFound|BetaCacheMissUnavailable|null $cacheMissReason,
    ): self {
        $self = new self;

        $self['cacheMissReason'] = $cacheMissReason;

        return $self;
    }

    /**
     * Explains why the prompt cache could not fully reuse the prefix from the request identified by `diagnostics.previous_message_id`. `null` means diagnosis is still pending — the response was serialized before the background comparison completed.
     *
     * @param CacheMissReasonShape|null $cacheMissReason
     */
    public function withCacheMissReason(
        BetaCacheMissModelChanged|array|BetaCacheMissSystemChanged|BetaCacheMissToolsChanged|BetaCacheMissMessagesChanged|BetaCacheMissPreviousMessageNotFound|BetaCacheMissUnavailable|null $cacheMissReason,
    ): self {
        $self = clone $this;
        $self['cacheMissReason'] = $cacheMissReason;

        return $self;
    }
}
