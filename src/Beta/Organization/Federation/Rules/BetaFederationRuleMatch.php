<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Rules;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Does the incoming JWT qualify?
 *
 * All populated fields must pass; omitted fields are skipped. At least one
 * of `subject_prefix` (other than a wildcard-only value like `*`), `claims`,
 * or `condition` is required; `audience` alone is not sufficient.
 *
 * @phpstan-type BetaFederationRuleMatchShape = array{
 *   audience?: string|null,
 *   claims?: array<string,string>|null,
 *   condition?: string|null,
 *   subjectPrefix?: string|null,
 * }
 */
final class BetaFederationRuleMatch implements BaseModel
{
    /** @use SdkModel<BetaFederationRuleMatchShape> */
    use SdkModel;

    /**
     * Exact match against the `aud` claim (any element if array). When omitted, the JWT's `aud` must still equal Anthropic's expected audience for the issuer; setting this field overrides that default.
     */
    #[Optional(nullable: true)]
    public ?string $audience;

    /**
     * Exact-match `{claim: value}` pairs against top-level claims. Only string-valued claims can be matched; use `condition` for non-string claims.
     *
     * @var array<string,string>|null $claims
     */
    #[Optional(map: 'string', nullable: true)]
    public ?array $claims;

    /**
     * CEL expression over claims for logic the structural fields can't express. Must evaluate to a boolean and may reference only the `claims` variable; a constant-true expression (such as `true`) is rejected with 400.
     */
    #[Optional(nullable: true)]
    public ?string $condition;

    /**
     * Match the verified JWT `sub` claim. Exact match unless the value ends with `*`, in which case it is a prefix match. Example: `repo:my-org/my-repo:ref:refs/heads/main`.
     */
    #[Optional('subject_prefix', nullable: true)]
    public ?string $subjectPrefix;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string>|null $claims
     */
    public static function with(
        ?string $audience = null,
        ?array $claims = null,
        ?string $condition = null,
        ?string $subjectPrefix = null,
    ): self {
        $self = new self;

        null !== $audience && $self['audience'] = $audience;
        null !== $claims && $self['claims'] = $claims;
        null !== $condition && $self['condition'] = $condition;
        null !== $subjectPrefix && $self['subjectPrefix'] = $subjectPrefix;

        return $self;
    }

    /**
     * Exact match against the `aud` claim (any element if array). When omitted, the JWT's `aud` must still equal Anthropic's expected audience for the issuer; setting this field overrides that default.
     */
    public function withAudience(?string $audience): self
    {
        $self = clone $this;
        $self['audience'] = $audience;

        return $self;
    }

    /**
     * Exact-match `{claim: value}` pairs against top-level claims. Only string-valued claims can be matched; use `condition` for non-string claims.
     *
     * @param array<string,string>|null $claims
     */
    public function withClaims(?array $claims): self
    {
        $self = clone $this;
        $self['claims'] = $claims;

        return $self;
    }

    /**
     * CEL expression over claims for logic the structural fields can't express. Must evaluate to a boolean and may reference only the `claims` variable; a constant-true expression (such as `true`) is rejected with 400.
     */
    public function withCondition(?string $condition): self
    {
        $self = clone $this;
        $self['condition'] = $condition;

        return $self;
    }

    /**
     * Match the verified JWT `sub` claim. Exact match unless the value ends with `*`, in which case it is a prefix match. Example: `repo:my-org/my-repo:ref:refs/heads/main`.
     */
    public function withSubjectPrefix(?string $subjectPrefix): self
    {
        $self = clone $this;
        $self['subjectPrefix'] = $subjectPrefix;

        return $self;
    }
}
