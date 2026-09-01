<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaMessageParam\ClearAt;
use Anthropic\Beta\Messages\BetaMessageParam\Content;
use Anthropic\Beta\Messages\BetaMessageParam\Role;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Messages\BetaMessageParam\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaMessageParam\Content
 * @phpstan-import-type BetaSystemMessageOutputConfigShape from \Anthropic\Beta\Messages\BetaSystemMessageOutputConfig
 *
 * @phpstan-type BetaMessageParamShape = array{
 *   content: ContentShape,
 *   role: Role|value-of<Role>,
 *   clearAt?: null|ClearAt|value-of<ClearAt>,
 *   outputConfig?: null|BetaSystemMessageOutputConfig|BetaSystemMessageOutputConfigShape,
 * }
 */
final class BetaMessageParam implements BaseModel
{
    /** @use SdkModel<BetaMessageParamShape> */
    use SdkModel;

    /** @var ContentVariants $content */
    #[Required(union: Content::class)]
    public string|array $content;

    /** @var value-of<Role> $role */
    #[Required(enum: Role::class)]
    public string $role;

    /**
     * How long this system message's text stays in front of the model. `"never"` (the default) renders it on every request that includes it. `"next_user_message"` renders it only for the user turn it follows: once a later `role: "user"` message exists in `messages` the message stays in the array (send it unchanged) but is no longer shown to the model. Only permitted on `role: "system"` messages.
     *
     * @var value-of<ClearAt>|null $clearAt
     */
    #[Optional('clear_at', enum: ClearAt::class, nullable: true)]
    public ?string $clearAt;

    /**
     * Per-message output configuration on a role:"system" input message.
     *
     * Fields here apply per-turn; ``format`` remains top-level only. An
     * empty ``{}`` is accepted on a message that carries content; a message
     * with neither content nor output_config fields is rejected.
     */
    #[Optional('output_config', nullable: true)]
    public ?BetaSystemMessageOutputConfig $outputConfig;

    /**
     * `new BetaMessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMessageParam::with(content: ..., role: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMessageParam)->withContent(...)->withRole(...)
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
     * @param ContentShape $content
     * @param Role|value-of<Role> $role
     * @param ClearAt|value-of<ClearAt>|null $clearAt
     * @param BetaSystemMessageOutputConfig|BetaSystemMessageOutputConfigShape|null $outputConfig
     */
    public static function with(
        string|array $content,
        Role|string $role,
        ClearAt|string|null $clearAt = null,
        BetaSystemMessageOutputConfig|array|null $outputConfig = null,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['role'] = $role;

        null !== $clearAt && $self['clearAt'] = $clearAt;
        null !== $outputConfig && $self['outputConfig'] = $outputConfig;

        return $self;
    }

    /**
     * @param ContentShape $content
     */
    public function withContent(string|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param Role|value-of<Role> $role
     */
    public function withRole(Role|string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }

    /**
     * How long this system message's text stays in front of the model. `"never"` (the default) renders it on every request that includes it. `"next_user_message"` renders it only for the user turn it follows: once a later `role: "user"` message exists in `messages` the message stays in the array (send it unchanged) but is no longer shown to the model. Only permitted on `role: "system"` messages.
     *
     * @param ClearAt|value-of<ClearAt>|null $clearAt
     */
    public function withClearAt(ClearAt|string|null $clearAt): self
    {
        $self = clone $this;
        $self['clearAt'] = $clearAt;

        return $self;
    }

    /**
     * Per-message output configuration on a role:"system" input message.
     *
     * Fields here apply per-turn; ``format`` remains top-level only. An
     * empty ``{}`` is accepted on a message that carries content; a message
     * with neither content nor output_config fields is rejected.
     *
     * @param BetaSystemMessageOutputConfig|BetaSystemMessageOutputConfigShape|null $outputConfig
     */
    public function withOutputConfig(
        BetaSystemMessageOutputConfig|array|null $outputConfig
    ): self {
        $self = clone $this;
        $self['outputConfig'] = $outputConfig;

        return $self;
    }
}
