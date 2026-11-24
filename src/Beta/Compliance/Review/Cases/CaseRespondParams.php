<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Send your conclusion on a review case. A response closes the case, and a closed case can't be reopened.
 *
 * Only the first response counts. A request is safe to send again: if the closed case has a response with the same field values, in any list order, the API returns 200 and changes nothing. If the closed case has a different response, or none, the API returns a 400 with `case_closed` in `error.details.error_code`.
 *
 * If your end customer reviews this case instead of you, the API returns a 403 with `case_reviewed_by_end_customer` in `error.details.error_code`.
 *
 * An Admin API key with the `write:compliance_review_cases` scope can call this endpoint.
 *
 * @see Anthropic\Services\Beta\Compliance\Review\CasesService::respond()
 *
 * @phpstan-import-type BetaComplianceReviewVerdictParamShape from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewVerdictParam
 *
 * @phpstan-type CaseRespondParamsShape = array{
 *   determination: BetaComplianceReviewDetermination|value-of<BetaComplianceReviewDetermination>,
 *   policyCategories?: list<BetaComplianceReviewViolatedPolicyCategory|value-of<BetaComplianceReviewViolatedPolicyCategory>>|null,
 *   verdicts?: list<BetaComplianceReviewVerdictParam|BetaComplianceReviewVerdictParamShape>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class CaseRespondParams implements BaseModel
{
    /** @use SdkModel<CaseRespondParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Your conclusion on the case as a whole. Anthropic doesn't check it against `verdicts`.
     *
     * @var value-of<BetaComplianceReviewDetermination> $determination
     */
    #[Required(enum: BetaComplianceReviewDetermination::class)]
    public string $determination;

    /**
     * The policy categories that you found were violated. Send one to four with `violation`, and none with `no_violation`. They need not match the case's own. Each value is one of `cyber`, `bio`, `chem`, `radnuc` (radiological or nuclear weapons), `cgw` (conventional weapons), `mgw` (military-grade weapons systems), `io` (influence operations), `fraud`, `violent_extremism`, `surveillance`, `human_exploitation`, `self_harm`, `adult_content`, `reasoning_extraction`, `frontier_llm` (use of the model to accelerate frontier AI research and development in restricted ways), `compromised_key` or `other`, and can appear once.
     *
     * @var list<value-of<BetaComplianceReviewViolatedPolicyCategory>>|null $policyCategories
     */
    #[Optional(
        'policy_categories',
        list: BetaComplianceReviewViolatedPolicyCategory::class
    )]
    public ?array $policyCategories;

    /**
     * Your conclusions on individual messages of the case. They need not cover every message, and each `item_id` can appear once.
     *
     * @var list<BetaComplianceReviewVerdictParam>|null $verdicts
     */
    #[Optional(list: BetaComplianceReviewVerdictParam::class)]
    public ?array $verdicts;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new CaseRespondParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CaseRespondParams::with(determination: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CaseRespondParams())->withDetermination(...)
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
     * @param BetaComplianceReviewDetermination|value-of<BetaComplianceReviewDetermination> $determination
     * @param list<BetaComplianceReviewViolatedPolicyCategory|value-of<BetaComplianceReviewViolatedPolicyCategory>>|null $policyCategories
     * @param list<BetaComplianceReviewVerdictParam|BetaComplianceReviewVerdictParamShape>|null $verdicts
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        BetaComplianceReviewDetermination|string $determination,
        ?array $policyCategories = null,
        ?array $verdicts = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['determination'] = $determination;

        null !== $policyCategories && $self['policyCategories'] = $policyCategories;
        null !== $verdicts && $self['verdicts'] = $verdicts;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Your conclusion on the case as a whole. Anthropic doesn't check it against `verdicts`.
     *
     * @param BetaComplianceReviewDetermination|value-of<BetaComplianceReviewDetermination> $determination
     */
    public function withDetermination(
        BetaComplianceReviewDetermination|string $determination
    ): self {
        $self = clone $this;
        $self['determination'] = $determination;

        return $self;
    }

    /**
     * The policy categories that you found were violated. Send one to four with `violation`, and none with `no_violation`. They need not match the case's own. Each value is one of `cyber`, `bio`, `chem`, `radnuc` (radiological or nuclear weapons), `cgw` (conventional weapons), `mgw` (military-grade weapons systems), `io` (influence operations), `fraud`, `violent_extremism`, `surveillance`, `human_exploitation`, `self_harm`, `adult_content`, `reasoning_extraction`, `frontier_llm` (use of the model to accelerate frontier AI research and development in restricted ways), `compromised_key` or `other`, and can appear once.
     *
     * @param list<BetaComplianceReviewViolatedPolicyCategory|value-of<BetaComplianceReviewViolatedPolicyCategory>> $policyCategories
     */
    public function withPolicyCategories(array $policyCategories): self
    {
        $self = clone $this;
        $self['policyCategories'] = $policyCategories;

        return $self;
    }

    /**
     * Your conclusions on individual messages of the case. They need not cover every message, and each `item_id` can appear once.
     *
     * @param list<BetaComplianceReviewVerdictParam|BetaComplianceReviewVerdictParamShape> $verdicts
     */
    public function withVerdicts(array $verdicts): self
    {
        $self = clone $this;
        $self['verdicts'] = $verdicts;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
