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
 * Detach a Bundle from a Slack channel or a Slack workspace. A repeated detach returns 404.
 *
 * @see Anthropic\Services\Beta\Organization\ClaudeTag\Bundles\TargetsService::delete()
 *
 * @phpstan-type TargetDeleteParamsShape = array{
 *   bundleID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class TargetDeleteParams implements BaseModel
{
    /** @use SdkModel<TargetDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The Bundle's identifier, starting with `capp_`.
     */
    #[Required]
    public string $bundleID;

    /**
     * This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new TargetDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TargetDeleteParams::with(bundleID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TargetDeleteParams())->withBundleID(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(string $bundleID, ?array $betas = null): self
    {
        $self = new self;

        $self['bundleID'] = $bundleID;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * The Bundle's identifier, starting with `capp_`.
     */
    public function withBundleID(string $bundleID): self
    {
        $self = clone $this;
        $self['bundleID'] = $bundleID;

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
