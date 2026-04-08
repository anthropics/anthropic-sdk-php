<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Beta\Environments\BetaPackagesParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Specify packages (and optionally their versions) available in this environment.
 *
 * When versioning, use the version semantics relevant for the package manager, e.g. for `pip` use `package==1.0.0`. You are responsible for validating the package and version exist. Unversioned installs the latest.
 *
 * @phpstan-type BetaPackagesParamsShape = array{
 *   apt?: list<string>|null,
 *   cargo?: list<string>|null,
 *   gem?: list<string>|null,
 *   go?: list<string>|null,
 *   npm?: list<string>|null,
 *   pip?: list<string>|null,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class BetaPackagesParams implements BaseModel
{
    /** @use SdkModel<BetaPackagesParamsShape> */
    use SdkModel;

    /**
     * Ubuntu/Debian packages to install.
     *
     * @var list<string>|null $apt
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $apt;

    /**
     * Rust packages to install.
     *
     * @var list<string>|null $cargo
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $cargo;

    /**
     * Ruby packages to install.
     *
     * @var list<string>|null $gem
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $gem;

    /**
     * Go packages to install.
     *
     * @var list<string>|null $go
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $go;

    /**
     * Node.js packages to install.
     *
     * @var list<string>|null $npm
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $npm;

    /**
     * Python packages to install.
     *
     * @var list<string>|null $pip
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $pip;

    /**
     * Package configuration type.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $apt
     * @param list<string>|null $cargo
     * @param list<string>|null $gem
     * @param list<string>|null $go
     * @param list<string>|null $npm
     * @param list<string>|null $pip
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?array $apt = null,
        ?array $cargo = null,
        ?array $gem = null,
        ?array $go = null,
        ?array $npm = null,
        ?array $pip = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        null !== $apt && $self['apt'] = $apt;
        null !== $cargo && $self['cargo'] = $cargo;
        null !== $gem && $self['gem'] = $gem;
        null !== $go && $self['go'] = $go;
        null !== $npm && $self['npm'] = $npm;
        null !== $pip && $self['pip'] = $pip;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Ubuntu/Debian packages to install.
     *
     * @param list<string>|null $apt
     */
    public function withApt(?array $apt): self
    {
        $self = clone $this;
        $self['apt'] = $apt;

        return $self;
    }

    /**
     * Rust packages to install.
     *
     * @param list<string>|null $cargo
     */
    public function withCargo(?array $cargo): self
    {
        $self = clone $this;
        $self['cargo'] = $cargo;

        return $self;
    }

    /**
     * Ruby packages to install.
     *
     * @param list<string>|null $gem
     */
    public function withGem(?array $gem): self
    {
        $self = clone $this;
        $self['gem'] = $gem;

        return $self;
    }

    /**
     * Go packages to install.
     *
     * @param list<string>|null $go
     */
    public function withGo(?array $go): self
    {
        $self = clone $this;
        $self['go'] = $go;

        return $self;
    }

    /**
     * Node.js packages to install.
     *
     * @param list<string>|null $npm
     */
    public function withNpm(?array $npm): self
    {
        $self = clone $this;
        $self['npm'] = $npm;

        return $self;
    }

    /**
     * Python packages to install.
     *
     * @param list<string>|null $pip
     */
    public function withPip(?array $pip): self
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
