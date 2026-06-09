<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRefusalStopDetails\Category;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Structured information about a refusal.
 *
 * @phpstan-type BetaRefusalStopDetailsShape = array{
 *   category: null|Category|value-of<Category>,
 *   explanation: string|null,
 *   fallbackCreditToken: string|null,
 *   fallbackHasPrefillClaim: bool|null,
 *   recommendedModel: string|null,
 *   type: 'refusal',
 * }
 */
final class BetaRefusalStopDetails implements BaseModel
{
    /** @use SdkModel<BetaRefusalStopDetailsShape> */
    use SdkModel;

    /** @var 'refusal' $type */
    #[Required]
    public string $type = 'refusal';

    /**
     * The policy category that triggered the refusal.
     *
     * `null` when the refusal doesn't map to a named category.
     *
     * @var value-of<Category>|null $category
     */
    #[Required(enum: Category::class)]
    public ?string $category;

    /**
     * Human-readable explanation of the refusal.
     *
     * This text is not guaranteed to be stable. `null` when no explanation is available for the category.
     */
    #[Required]
    public ?string $explanation;

    /**
     * Opaque code that refunds the cache-miss cost when retrying this refused
     * request on the fallback model. Pass it as `fallback_credit_token` on the
     * retry request. Expires 5 minutes after the refusal.
     *
     * The retry is sent either with the same request body (`system`, `messages`,
     * `tools`, and other render-shaping fields), or with the same body plus one
     * appended `assistant` message whose content is the partial text (with any
     * trailing whitespace stripped from the final text block) and paired
     * server-tool blocks from this refusal — which also authorizes that
     * appended turn as an assistant-prefill continuation on models that otherwise
     * disallow prefill. A token minted mid-server-tool-loop whose partial content
     * was continuable may only be redeemed the second way — if a same-body retry
     * is rejected with a 400 saying the token must be redeemed by continuing the
     * partial response, retry the second way instead. Either way: same workspace,
     * same platform; a mismatch is a 400. Resending a token for an already-warm
     * prefix is permitted but yields no additional credit.
     *
     * `null` when the refused model isn't eligible for a fallback credit.
     */
    #[Required('fallback_credit_token')]
    public ?string $fallbackCreditToken;

    /**
     * Whether the accompanying `fallback_credit_token` may be redeemed with the
     * appended-assistant retry form. Only set when `fallback_credit_token` is
     * present.
     *
     * `true`: retry by resending the same request body plus one appended
     * `assistant` message whose content is this response's `content` with any
     * trailing whitespace stripped from the final text block and unpaired
     * `tool_use` blocks omitted (the same appended-turn shape described on
     * `fallback_credit_token`), with the token attached. `false`: retry by
     * resending the original request body unchanged, with the token attached —
     * the appended-assistant form is not available for this refusal (no
     * continuable partial content, or the request uses `output_format` or a
     * `tool_choice` that forces tool use). One exception: when the request used
     * `output_format` or a forced `tool_choice` and the refusal arrived after
     * server tools (including MCP connector tools) had already executed, the
     * token may not be redeemable by either retry form; if the exact-body retry
     * is then rejected with a 400 saying the token must be redeemed by
     * continuing the partial response, discard the token and retry without it.
     *
     * Advisory: if an appended-assistant retry is rejected with a 400 despite
     * `true`, fall back to resending the original request body with the token.
     */
    #[Required('fallback_has_prefill_claim')]
    public ?bool $fallbackHasPrefillClaim;

    /**
     * The server's suggested retry target for this refusal. Populated when a fallback attempt could not be made (the fallback model's rate limit was exhausted, or it was overloaded); names the fallback model the caller can retry directly. Null otherwise.
     */
    #[Required('recommended_model')]
    public ?string $recommendedModel;

    /**
     * `new BetaRefusalStopDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRefusalStopDetails::with(
     *   category: ...,
     *   explanation: ...,
     *   fallbackCreditToken: ...,
     *   fallbackHasPrefillClaim: ...,
     *   recommendedModel: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRefusalStopDetails)
     *   ->withCategory(...)
     *   ->withExplanation(...)
     *   ->withFallbackCreditToken(...)
     *   ->withFallbackHasPrefillClaim(...)
     *   ->withRecommendedModel(...)
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
     * @param Category|value-of<Category>|null $category
     */
    public static function with(
        Category|string|null $category,
        ?string $explanation,
        ?string $fallbackCreditToken,
        ?bool $fallbackHasPrefillClaim,
        ?string $recommendedModel,
    ): self {
        $self = new self;

        $self['category'] = $category;
        $self['explanation'] = $explanation;
        $self['fallbackCreditToken'] = $fallbackCreditToken;
        $self['fallbackHasPrefillClaim'] = $fallbackHasPrefillClaim;
        $self['recommendedModel'] = $recommendedModel;

        return $self;
    }

    /**
     * The policy category that triggered the refusal.
     *
     * `null` when the refusal doesn't map to a named category.
     *
     * @param Category|value-of<Category>|null $category
     */
    public function withCategory(Category|string|null $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Human-readable explanation of the refusal.
     *
     * This text is not guaranteed to be stable. `null` when no explanation is available for the category.
     */
    public function withExplanation(?string $explanation): self
    {
        $self = clone $this;
        $self['explanation'] = $explanation;

        return $self;
    }

    /**
     * Opaque code that refunds the cache-miss cost when retrying this refused
     * request on the fallback model. Pass it as `fallback_credit_token` on the
     * retry request. Expires 5 minutes after the refusal.
     *
     * The retry is sent either with the same request body (`system`, `messages`,
     * `tools`, and other render-shaping fields), or with the same body plus one
     * appended `assistant` message whose content is the partial text (with any
     * trailing whitespace stripped from the final text block) and paired
     * server-tool blocks from this refusal — which also authorizes that
     * appended turn as an assistant-prefill continuation on models that otherwise
     * disallow prefill. A token minted mid-server-tool-loop whose partial content
     * was continuable may only be redeemed the second way — if a same-body retry
     * is rejected with a 400 saying the token must be redeemed by continuing the
     * partial response, retry the second way instead. Either way: same workspace,
     * same platform; a mismatch is a 400. Resending a token for an already-warm
     * prefix is permitted but yields no additional credit.
     *
     * `null` when the refused model isn't eligible for a fallback credit.
     */
    public function withFallbackCreditToken(?string $fallbackCreditToken): self
    {
        $self = clone $this;
        $self['fallbackCreditToken'] = $fallbackCreditToken;

        return $self;
    }

    /**
     * Whether the accompanying `fallback_credit_token` may be redeemed with the
     * appended-assistant retry form. Only set when `fallback_credit_token` is
     * present.
     *
     * `true`: retry by resending the same request body plus one appended
     * `assistant` message whose content is this response's `content` with any
     * trailing whitespace stripped from the final text block and unpaired
     * `tool_use` blocks omitted (the same appended-turn shape described on
     * `fallback_credit_token`), with the token attached. `false`: retry by
     * resending the original request body unchanged, with the token attached —
     * the appended-assistant form is not available for this refusal (no
     * continuable partial content, or the request uses `output_format` or a
     * `tool_choice` that forces tool use). One exception: when the request used
     * `output_format` or a forced `tool_choice` and the refusal arrived after
     * server tools (including MCP connector tools) had already executed, the
     * token may not be redeemable by either retry form; if the exact-body retry
     * is then rejected with a 400 saying the token must be redeemed by
     * continuing the partial response, discard the token and retry without it.
     *
     * Advisory: if an appended-assistant retry is rejected with a 400 despite
     * `true`, fall back to resending the original request body with the token.
     */
    public function withFallbackHasPrefillClaim(
        ?bool $fallbackHasPrefillClaim
    ): self {
        $self = clone $this;
        $self['fallbackHasPrefillClaim'] = $fallbackHasPrefillClaim;

        return $self;
    }

    /**
     * The server's suggested retry target for this refusal. Populated when a fallback attempt could not be made (the fallback model's rate limit was exhausted, or it was overloaded); names the fallback model the caller can retry directly. Null otherwise.
     */
    public function withRecommendedModel(?string $recommendedModel): self
    {
        $self = clone $this;
        $self['recommendedModel'] = $recommendedModel;

        return $self;
    }

    /**
     * @param 'refusal' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
