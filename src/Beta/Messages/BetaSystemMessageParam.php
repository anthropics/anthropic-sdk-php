<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaSystemMessageParam\ClearAt;
use Anthropic\Beta\Messages\BetaSystemMessageParam\Content;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaSystemMessageParam\Content
 * @phpstan-import-type BetaSystemMessageOutputConfigShape from \Anthropic\Beta\Messages\BetaSystemMessageOutputConfig
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Messages\BetaSystemMessageParam\Content
 *
 * @phpstan-type BetaSystemMessageParamShape = array{
 *   role: 'system',
 *   clearAt?: null|ClearAt|value-of<ClearAt>,
 *   content?: ContentShape|null,
 *   outputConfig?: null|BetaSystemMessageOutputConfig|BetaSystemMessageOutputConfigShape,
 * }
 */
final class BetaSystemMessageParam implements BaseModel
{
    /** @use SdkModel<BetaSystemMessageParamShape> */
    use SdkModel;

    /** @var 'system' $role */
    #[Required(type: new ConstantOf('system'))]
    public string $role = 'system';

    /**
     * How long this system message's text stays in front of the model. `"never"` (the default) renders it on every request that includes it. `"next_user_message"` renders it only for the user turn it follows: once a later `role: "user"` message exists in `messages` the message stays in the array (send it unchanged) but is no longer shown to the model. Only permitted on `role: "system"` messages.
     *
     * @var value-of<ClearAt>|null $clearAt
     */
    #[Optional('clear_at', enum: ClearAt::class, nullable: true)]
    public ?string $clearAt;

    /** @var ContentVariants|null $content */
    #[Optional(union: Content::class)]
    public string|array|null $content;

    /**
     * Per-message output configuration on a role:"system" input message.
     *
     * Fields here apply per-turn; ``format`` remains top-level only. An
     * empty ``{}`` is accepted on a message that carries content; a message
     * with neither content nor output_config fields is rejected.
     */
    #[Optional('output_config', nullable: true)]
    public ?BetaSystemMessageOutputConfig $outputConfig;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ClearAt|value-of<ClearAt>|null $clearAt
     * @param ContentShape|null $content
     * @param BetaSystemMessageOutputConfig|BetaSystemMessageOutputConfigShape|null $outputConfig
     */
    public static function with(
        ClearAt|string|null $clearAt = null,
        string|array|null $content = null,
        BetaSystemMessageOutputConfig|array|null $outputConfig = null,
    ): self {
        $self = new self;

        null !== $clearAt && $self['clearAt'] = $clearAt;
        null !== $content && $self['content'] = $content;
        null !== $outputConfig && $self['outputConfig'] = $outputConfig;

        return $self;
    }

    /**
     * @param 'system' $role
     */
    public function withRole(string $role): self
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
     * @param ContentShape $content
     */
    public function withContent(string|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

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
