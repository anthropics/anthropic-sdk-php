<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The tool filter variant under which every result but the named
 * tools' contributes.
 *
 * @phpstan-import-type WebFetchURLSourceToolReferenceShape from \Anthropic\Messages\WebFetchURLSourceToolReference
 *
 * @phpstan-type WebFetchURLSourceExceptShape = array{
 *   tools: list<WebFetchURLSourceToolReference|WebFetchURLSourceToolReferenceShape>,
 *   type: 'except',
 * }
 */
final class WebFetchURLSourceExcept implements BaseModel
{
    /** @use SdkModel<WebFetchURLSourceExceptShape> */
    use SdkModel;

    /** @var 'except' $type */
    #[Required(type: new ConstantOf('except'))]
    public string $type = 'except';

    /** @var list<WebFetchURLSourceToolReference> $tools */
    #[Required(list: WebFetchURLSourceToolReference::class)]
    public array $tools;

    /**
     * `new WebFetchURLSourceExcept()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebFetchURLSourceExcept::with(tools: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebFetchURLSourceExcept)->withTools(...)
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
     * @param list<WebFetchURLSourceToolReference|WebFetchURLSourceToolReferenceShape> $tools
     */
    public static function with(array $tools): self
    {
        $self = new self;

        $self['tools'] = $tools;

        return $self;
    }

    /**
     * @param list<WebFetchURLSourceToolReference|WebFetchURLSourceToolReferenceShape> $tools
     */
    public function withTools(array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * @param 'except' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
