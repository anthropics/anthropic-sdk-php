<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Request-level diagnostics: why the prompt cache could not fully reuse
 * the prefix of the request named by `diagnostics.previous_message_id`.
 *
 * @phpstan-import-type CacheMissReasonShape from \Anthropic\Messages\CacheMissReason
 * @phpstan-import-type CacheMissReasonVariants from \Anthropic\Messages\CacheMissReason
 *
 * @phpstan-type DiagnosticsShape = array{
 *   cacheMissReason: CacheMissReasonShape|null
 * }
 */
final class Diagnostics implements BaseModel
{
    /** @use SdkModel<DiagnosticsShape> */
    use SdkModel;

    /**
     * Explains why the prompt cache could not fully reuse the prefix from the request identified by `diagnostics.previous_message_id`. `null` means diagnosis is still pending — the response was serialized before the background comparison completed.
     *
     * @var CacheMissReasonVariants|null $cacheMissReason
     */
    #[Required('cache_miss_reason', union: CacheMissReason::class)]
    public CacheMissModelChanged|CacheMissSystemChanged|CacheMissToolsChanged|CacheMissMessagesChanged|CacheMissPreviousMessageNotFound|CacheMissUnavailable|null $cacheMissReason;

    /**
     * `new Diagnostics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Diagnostics::with(cacheMissReason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Diagnostics())->withCacheMissReason(...)
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
        CacheMissModelChanged|array|CacheMissSystemChanged|CacheMissToolsChanged|CacheMissMessagesChanged|CacheMissPreviousMessageNotFound|CacheMissUnavailable|null $cacheMissReason,
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
        CacheMissModelChanged|array|CacheMissSystemChanged|CacheMissToolsChanged|CacheMissMessagesChanged|CacheMissPreviousMessageNotFound|CacheMissUnavailable|null $cacheMissReason,
    ): self {
        $self = clone $this;
        $self['cacheMissReason'] = $cacheMissReason;

        return $self;
    }
}
