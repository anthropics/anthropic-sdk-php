<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaSkill\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Information about the container used in the request (for the code execution tool).
 *
 * @phpstan-type BetaContainerShape = array{
 *   id: string, expiresAt: \DateTimeInterface, skills: list<BetaSkill>|null
 * }
 */
final class BetaContainer implements BaseModel
{
    /** @use SdkModel<BetaContainerShape> */
    use SdkModel;

    /**
     * Identifier for the container used in this request.
     */
    #[Required]
    public string $id;

    /**
     * The time at which the container will expire.
     */
    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * Skills loaded in the container.
     *
     * @var list<BetaSkill>|null $skills
     */
    #[Required(list: BetaSkill::class)]
    public ?array $skills;

    /**
     * `new BetaContainer()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaContainer::with(id: ..., expiresAt: ..., skills: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaContainer)->withID(...)->withExpiresAt(...)->withSkills(...)
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
     * @param list<BetaSkill|array{
     *   skillID: string, type: value-of<Type>, version: string
     * }>|null $skills
     */
    public static function with(
        string $id,
        \DateTimeInterface $expiresAt,
        ?array $skills
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['expiresAt'] = $expiresAt;
        $obj['skills'] = $skills;

        return $obj;
    }

    /**
     * Identifier for the container used in this request.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

        return $obj;
    }

    /**
     * The time at which the container will expire.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $obj = clone $this;
        $obj['expiresAt'] = $expiresAt;

        return $obj;
    }

    /**
     * Skills loaded in the container.
     *
     * @param list<BetaSkill|array{
     *   skillID: string, type: value-of<Type>, version: string
     * }>|null $skills
     */
    public function withSkills(?array $skills): self
    {
        $obj = clone $this;
        $obj['skills'] = $skills;

        return $obj;
    }
}
