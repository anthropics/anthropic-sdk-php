<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;
use Anthropic\Messages\SystemMessageParam\Content;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Messages\SystemMessageParam\Content
 * @phpstan-import-type ContentVariants from \Anthropic\Messages\SystemMessageParam\Content
 *
 * @phpstan-type SystemMessageParamShape = array{
 *   content: ContentShape, role: 'system'
 * }
 */
final class SystemMessageParam implements BaseModel
{
    /** @use SdkModel<SystemMessageParamShape> */
    use SdkModel;

    /** @var 'system' $role */
    #[Required(type: new ConstantOf('system'))]
    public string $role = 'system';

    /** @var ContentVariants $content */
    #[Required(union: Content::class)]
    public string|array $content;

    /**
     * `new SystemMessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SystemMessageParam::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SystemMessageParam())->withContent(...)
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
     */
    public static function with(string|array $content): self
    {
        $self = new self;

        $self['content'] = $content;

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
     * @param 'system' $role
     */
    public function withRole(string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }
}
