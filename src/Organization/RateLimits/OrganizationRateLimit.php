<?php

declare(strict_types=1);

namespace Anthropic\Organization\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;
use Anthropic\Organization\RateLimits\OrganizationRateLimit\Group;

/**
 * @phpstan-import-type GroupVariants from \Anthropic\Organization\RateLimits\OrganizationRateLimit\Group
 * @phpstan-import-type GroupShape from \Anthropic\Organization\RateLimits\OrganizationRateLimit\Group
 * @phpstan-import-type OrganizationRateLimitValueShape from \Anthropic\Organization\RateLimits\OrganizationRateLimitValue
 *
 * @phpstan-type OrganizationRateLimitShape = array{
 *   id: string,
 *   group: GroupShape,
 *   limits: list<OrganizationRateLimitValue|OrganizationRateLimitValueShape>,
 *   models: list<string>|null,
 *   type: 'rate_limit',
 * }
 */
final class OrganizationRateLimit implements BaseModel
{
    /** @use SdkModel<OrganizationRateLimitShape> */
    use SdkModel;

    /**
     * Object type. Always `rate_limit` for organization rate-limit entries.
     *
     * @var 'rate_limit' $type
     */
    #[Required(type: new ConstantOf('rate_limit'))]
    public string $type = 'rate_limit';

    /**
     * Identifier of this rate-limit entry. It is stable within the organization and differs between organizations; the group's own identifier is `group.id`.
     */
    #[Required]
    public string $id;

    /**
     * The rate-limit group this entry's limits apply to. Its `type` equals `group_type`.
     *
     * @var GroupVariants $group
     */
    #[Required(union: Group::class)]
    public OrganizationRateLimitModelGroup|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup $group;

    /**
     * The limiter values that apply to this group.
     *
     * @var list<OrganizationRateLimitValue> $limits
     */
    #[Required(list: OrganizationRateLimitValue::class)]
    public array $limits;

    /**
     * Model names this entry's limits apply to, including aliases. `null` when `group_type` is not `"model_group"`.
     *
     * @var list<string>|null $models
     */
    #[Required(list: 'string')]
    public ?array $models;

    /**
     * `new OrganizationRateLimit()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationRateLimit::with(id: ..., group: ..., limits: ..., models: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationRateLimit)
     *   ->withID(...)
     *   ->withGroup(...)
     *   ->withLimits(...)
     *   ->withModels(...)
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
     * @param GroupShape $group
     * @param list<OrganizationRateLimitValue|OrganizationRateLimitValueShape> $limits
     * @param list<string>|null $models
     */
    public static function with(
        string $id,
        OrganizationRateLimitModelGroup|array|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup $group,
        array $limits,
        ?array $models,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['group'] = $group;
        $self['limits'] = $limits;
        $self['models'] = $models;

        return $self;
    }

    /**
     * Identifier of this rate-limit entry. It is stable within the organization and differs between organizations; the group's own identifier is `group.id`.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The rate-limit group this entry's limits apply to. Its `type` equals `group_type`.
     *
     * @param GroupShape $group
     */
    public function withGroup(
        OrganizationRateLimitModelGroup|array|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup $group,
    ): self {
        $self = clone $this;
        $self['group'] = $group;

        return $self;
    }

    /**
     * The limiter values that apply to this group.
     *
     * @param list<OrganizationRateLimitValue|OrganizationRateLimitValueShape> $limits
     */
    public function withLimits(array $limits): self
    {
        $self = clone $this;
        $self['limits'] = $limits;

        return $self;
    }

    /**
     * Model names this entry's limits apply to, including aliases. `null` when `group_type` is not `"model_group"`.
     *
     * @param list<string>|null $models
     */
    public function withModels(?array $models): self
    {
        $self = clone $this;
        $self['models'] = $models;

        return $self;
    }

    /**
     * Object type. Always `rate_limit` for organization rate-limit entries.
     *
     * @param 'rate_limit' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
