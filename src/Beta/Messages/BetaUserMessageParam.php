<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaMessageContentParamShape from \Anthropic\Beta\Messages\BetaMessageContentParam
 * @phpstan-import-type BetaMessageContentParamVariants from \Anthropic\Beta\Messages\BetaMessageContentParam
 *
 * @phpstan-type BetaUserMessageParamShape = array{
 *   content: BetaMessageContentParamShape, role: 'user'
 * }
 */
final class BetaUserMessageParam implements BaseModel
{
    /** @use SdkModel<BetaUserMessageParamShape> */
    use SdkModel;

    /** @var 'user' $role */
    #[Required(type: new ConstantOf('user'))]
    public string $role = 'user';

    /** @var BetaMessageContentParamVariants $content */
    #[Required(union: BetaMessageContentParam::class)]
    public string|array $content;

    /**
     * `new BetaUserMessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaUserMessageParam::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaUserMessageParam())->withContent(...)
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
     * @param BetaMessageContentParamShape $content
     */
    public static function with(string|array $content): self
    {
        $self = new self;

        $self['content'] = $content;

        return $self;
    }

    /**
     * @param BetaMessageContentParamShape $content
     */
    public function withContent(string|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param 'user' $role
     */
    public function withRole(string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }
}
