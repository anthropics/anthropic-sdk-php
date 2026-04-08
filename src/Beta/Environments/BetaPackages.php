<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Beta\Environments\BetaPackages\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Packages (and their versions) available in this environment.
 *
 * @phpstan-type BetaPackagesShape = array{
 *   apt: list<string>,
 *   cargo: list<string>,
 *   gem: list<string>,
 *   go: list<string>,
 *   npm: list<string>,
 *   pip: list<string>,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class BetaPackages implements BaseModel
{
    /** @use SdkModel<BetaPackagesShape> */
    use SdkModel;

    /**
     * Ubuntu/Debian packages to install.
     *
     * @var list<string> $apt
     */
    #[Required(list: 'string')]
    public array $apt;

    /**
     * Rust packages to install.
     *
     * @var list<string> $cargo
     */
    #[Required(list: 'string')]
    public array $cargo;

    /**
     * Ruby packages to install.
     *
     * @var list<string> $gem
     */
    #[Required(list: 'string')]
    public array $gem;

    /**
     * Go packages to install.
     *
     * @var list<string> $go
     */
    #[Required(list: 'string')]
    public array $go;

    /**
     * Node.js packages to install.
     *
     * @var list<string> $npm
     */
    #[Required(list: 'string')]
    public array $npm;

    /**
     * Python packages to install.
     *
     * @var list<string> $pip
     */
    #[Required(list: 'string')]
    public array $pip;

    /**
     * Package configuration type.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * `new BetaPackages()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaPackages::with(apt: ..., cargo: ..., gem: ..., go: ..., npm: ..., pip: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaPackages)
     *   ->withApt(...)
     *   ->withCargo(...)
     *   ->withGem(...)
     *   ->withGo(...)
     *   ->withNpm(...)
     *   ->withPip(...)
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
     * @param list<string> $apt
     * @param list<string> $cargo
     * @param list<string> $gem
     * @param list<string> $go
     * @param list<string> $npm
     * @param list<string> $pip
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        array $apt,
        array $cargo,
        array $gem,
        array $go,
        array $npm,
        array $pip,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        $self['apt'] = $apt;
        $self['cargo'] = $cargo;
        $self['gem'] = $gem;
        $self['go'] = $go;
        $self['npm'] = $npm;
        $self['pip'] = $pip;

        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Ubuntu/Debian packages to install.
     *
     * @param list<string> $apt
     */
    public function withApt(array $apt): self
    {
        $self = clone $this;
        $self['apt'] = $apt;

        return $self;
    }

    /**
     * Rust packages to install.
     *
     * @param list<string> $cargo
     */
    public function withCargo(array $cargo): self
    {
        $self = clone $this;
        $self['cargo'] = $cargo;

        return $self;
    }

    /**
     * Ruby packages to install.
     *
     * @param list<string> $gem
     */
    public function withGem(array $gem): self
    {
        $self = clone $this;
        $self['gem'] = $gem;

        return $self;
    }

    /**
     * Go packages to install.
     *
     * @param list<string> $go
     */
    public function withGo(array $go): self
    {
        $self = clone $this;
        $self['go'] = $go;

        return $self;
    }

    /**
     * Node.js packages to install.
     *
     * @param list<string> $npm
     */
    public function withNpm(array $npm): self
    {
        $self = clone $this;
        $self['npm'] = $npm;

        return $self;
    }

    /**
     * Python packages to install.
     *
     * @param list<string> $pip
     */
    public function withPip(array $pip): self
    {
        $self = clone $this;
        $self['pip'] = $pip;

        return $self;
    }

    /**
     * Package configuration type.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
