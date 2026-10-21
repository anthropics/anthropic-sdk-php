<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type MessageContentParamShape from \Anthropic\Messages\MessageContentParam
 * @phpstan-import-type MessageContentParamVariants from \Anthropic\Messages\MessageContentParam
 *
 * @phpstan-type AssistantMessageParamShape = array{
 *   content: MessageContentParamShape, role: 'assistant'
 * }
 */
final class AssistantMessageParam implements BaseModel
{
    /** @use SdkModel<AssistantMessageParamShape> */
    use SdkModel;

    /** @var 'assistant' $role */
    #[Required(type: new ConstantOf('assistant'))]
    public string $role = 'assistant';

    /** @var MessageContentParamVariants $content */
    #[Required(union: MessageContentParam::class)]
    public string|array $content;

    /**
     * `new AssistantMessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AssistantMessageParam::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AssistantMessageParam())->withContent(...)
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
     * @param MessageContentParamShape $content
     */
    public static function with(string|array $content): self
    {
        $self = new self;

        $self['content'] = $content;

        return $self;
    }

    /**
     * @param MessageContentParamShape $content
     */
    public function withContent(string|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * @param 'assistant' $role
     */
    public function withRole(string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }
}
