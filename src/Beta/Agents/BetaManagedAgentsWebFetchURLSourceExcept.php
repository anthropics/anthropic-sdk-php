<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Every tool's results contribute URLs that may be fetched, except the named tools' results.
 *
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceToolReferenceShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceToolReference
 *
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceExceptShape = array{
 *   tools: list<BetaManagedAgentsWebFetchURLSourceToolReference|BetaManagedAgentsWebFetchURLSourceToolReferenceShape>,
 *   type: 'except',
 * }
 */
final class BetaManagedAgentsWebFetchURLSourceExcept implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWebFetchURLSourceExceptShape> */
    use SdkModel;

    /** @var 'except' $type */
    #[Required(type: new ConstantOf('except'))]
    public string $type = 'except';

    /**
     * The tools whose results do not contribute. Between 1 and 128 entries, each with a different name. An empty list is rejected; use "all" to leave out no tool's results.
     *
     * @var list<BetaManagedAgentsWebFetchURLSourceToolReference> $tools
     */
    #[Required(list: BetaManagedAgentsWebFetchURLSourceToolReference::class)]
    public array $tools;

    /**
     * `new BetaManagedAgentsWebFetchURLSourceExcept()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsWebFetchURLSourceExcept::with(tools: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsWebFetchURLSourceExcept())->withTools(...)
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
     * @param list<BetaManagedAgentsWebFetchURLSourceToolReference|BetaManagedAgentsWebFetchURLSourceToolReferenceShape> $tools
     */
    public static function with(array $tools): self
    {
        $self = new self;

        $self['tools'] = $tools;

        return $self;
    }

    /**
     * The tools whose results do not contribute. Between 1 and 128 entries, each with a different name. An empty list is rejected; use "all" to leave out no tool's results.
     *
     * @param list<BetaManagedAgentsWebFetchURLSourceToolReference|BetaManagedAgentsWebFetchURLSourceToolReferenceShape> $tools
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
