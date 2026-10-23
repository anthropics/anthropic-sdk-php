<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Attach a Bundle to a Slack channel or a Slack workspace. A Bundle attached to a workspace can be used in the workspace and in every channel in it. Attaching a Bundle to a channel or workspace it is already attached to returns the existing Bundle Target. The channel or workspace must be set up: attaching never sets a channel up. A group direct message takes no Bundle and returns 400.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\Bundles\TargetsService::create()
 *
 * @phpstan-import-type BetaClaudeTagBundleTargetCreateShape from \Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagBundleTargetCreate
 * @phpstan-import-type BetaClaudeTagBundleTargetCreateVariants from \Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagBundleTargetCreate
 *
 * @phpstan-type TargetCreateParamsShape = array{
 *   target: BetaClaudeTagBundleTargetCreateShape,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class TargetCreateParams implements BaseModel
{
    /** @use SdkModel<TargetCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var BetaClaudeTagBundleTargetCreateVariants $target */
    #[Required(union: BetaClaudeTagBundleTargetCreate::class)]
    public BetaClaudeTagSlackChannelBundleTargetCreate|BetaClaudeTagSlackWorkspaceBundleTargetCreate $target;

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new TargetCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TargetCreateParams::with(target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TargetCreateParams())->withTarget(...)
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
     * @param BetaClaudeTagBundleTargetCreateShape $target
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        BetaClaudeTagSlackChannelBundleTargetCreate|array|BetaClaudeTagSlackWorkspaceBundleTargetCreate $target,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['target'] = $target;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * @param BetaClaudeTagBundleTargetCreateShape $target
     */
    public function withTarget(
        BetaClaudeTagSlackChannelBundleTargetCreate|array|BetaClaudeTagSlackWorkspaceBundleTargetCreate $target,
    ): self {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
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
