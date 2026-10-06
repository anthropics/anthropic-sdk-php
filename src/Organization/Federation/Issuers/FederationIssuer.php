<?php

declare(strict_types=1);

namespace Anthropic\Organization\Federation\Issuers;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;
use Anthropic\Organization\Federation\Issuers\FederationIssuer\JWKS;

/**
 * Registered external OIDC identity provider.
 *
 * Records an external IdP the organization trusts for the RFC 7523
 * jwt-bearer grant. The `issuer_url` must match the JWT `iss` claim exactly.
 *
 * @phpstan-import-type JWKSShape from \Anthropic\Organization\Federation\Issuers\FederationIssuer\JWKS
 * @phpstan-import-type FederationIssuerPollStatusShape from \Anthropic\Organization\Federation\Issuers\FederationIssuerPollStatus
 * @phpstan-import-type JWKSVariants from \Anthropic\Organization\Federation\Issuers\FederationIssuer\JWKS
 *
 * @phpstan-type FederationIssuerShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   archivedByActorID: string|null,
 *   checkJTI: bool,
 *   createdAt: \DateTimeInterface,
 *   createdByActorID: string|null,
 *   issuerURL: string,
 *   jwks: JWKSShape,
 *   jwksPollingDisabledAt: \DateTimeInterface|null,
 *   maxJWTLifetimeSeconds: int,
 *   name: string,
 *   pollStatus: null|FederationIssuerPollStatus|FederationIssuerPollStatusShape,
 *   type: 'federation_issuer',
 *   updatedAt: \DateTimeInterface,
 *   updatedByActorID: string|null,
 * }
 */
final class FederationIssuer implements BaseModel
{
    /** @use SdkModel<FederationIssuerShape> */
    use SdkModel;

    /** @var 'federation_issuer' $type */
    #[Required(type: new ConstantOf('federation_issuer'))]
    public string $type = 'federation_issuer';

    /**
     * Tagged ID of the federation issuer.
     */
    #[Required]
    public string $id;

    /**
     * If set, all rules referencing this issuer reject token exchange.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that archived this issuer.
     */
    #[Required('archived_by_actor_id')]
    public ?string $archivedByActorID;

    /**
     * Whether the jwt-bearer exchange enforces JTI single-use (replay protection) for tokens from this issuer. Applies only to assertions carrying a `jti` claim; tokens without one are accepted without single-use enforcement.
     */
    #[Required('check_jti')]
    public bool $checkJTI;

    /**
     * When this issuer was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that created this issuer.
     */
    #[Required('created_by_actor_id')]
    public ?string $createdByActorID;

    /**
     * The `iss` claim value. Incoming JWTs must match exactly.
     */
    #[Required('issuer_url')]
    public string $issuerURL;

    /**
     * How signing keys are obtained for signature verification.
     *
     * @var JWKSVariants $jwks
     */
    #[Required(union: JWKS::class)]
    public JWKSDiscovery|JWKSExplicitURL|JWKSInline $jwks;

    /**
     * If set, Anthropic's JWKS poller has paused polling for this issuer after repeated fetch failures. Re-enable by sending `jwks_polling_disabled: false` via the issuer update endpoint (POST) once the upstream JWKS endpoint is fixed. An OAuth caller cannot send this when the issuer backs a rule with any scope other than `workspace:developer` or `workspace:inference`; use a Console session.
     */
    #[Required('jwks_polling_disabled_at')]
    public ?\DateTimeInterface $jwksPollingDisabledAt;

    /**
     * Maximum allowed iat→exp spread for assertions from this issuer (1-176400 seconds, i.e. up to 49h). Assertions must carry both `iat` and `exp`; a missing `iat` is rejected.
     */
    #[Required('max_jwt_lifetime_seconds')]
    public int $maxJWTLifetimeSeconds;

    /**
     * Admin-chosen slug identifier.
     */
    #[Required]
    public string $name;

    /**
     * Live state of Anthropic's JWKS polling for this issuer. Populated on both single-issuer retrieval and list responses, including archived issuers. Typically null for inline-key issuers (no polling), or when poll status is temporarily unavailable or polling has not started yet.
     */
    #[Required('poll_status')]
    public ?FederationIssuerPollStatus $pollStatus;

    /**
     * When this issuer was last updated.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that last updated this issuer.
     */
    #[Required('updated_by_actor_id')]
    public ?string $updatedByActorID;

    /**
     * `new FederationIssuer()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FederationIssuer::with(
     *   id: ...,
     *   archivedAt: ...,
     *   archivedByActorID: ...,
     *   checkJTI: ...,
     *   createdAt: ...,
     *   createdByActorID: ...,
     *   issuerURL: ...,
     *   jwks: ...,
     *   jwksPollingDisabledAt: ...,
     *   maxJWTLifetimeSeconds: ...,
     *   name: ...,
     *   pollStatus: ...,
     *   updatedAt: ...,
     *   updatedByActorID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FederationIssuer())
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withArchivedByActorID(...)
     *   ->withCheckJTI(...)
     *   ->withCreatedAt(...)
     *   ->withCreatedByActorID(...)
     *   ->withIssuerURL(...)
     *   ->withJWKS(...)
     *   ->withJWKSPollingDisabledAt(...)
     *   ->withMaxJWTLifetimeSeconds(...)
     *   ->withName(...)
     *   ->withPollStatus(...)
     *   ->withUpdatedAt(...)
     *   ->withUpdatedByActorID(...)
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
     * @param JWKSShape $jwks
     * @param FederationIssuerPollStatus|FederationIssuerPollStatusShape|null $pollStatus
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        ?string $archivedByActorID,
        bool $checkJTI,
        \DateTimeInterface $createdAt,
        ?string $createdByActorID,
        string $issuerURL,
        JWKSDiscovery|array|JWKSExplicitURL|JWKSInline $jwks,
        ?\DateTimeInterface $jwksPollingDisabledAt,
        int $maxJWTLifetimeSeconds,
        string $name,
        FederationIssuerPollStatus|array|null $pollStatus,
        \DateTimeInterface $updatedAt,
        ?string $updatedByActorID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['archivedByActorID'] = $archivedByActorID;
        $self['checkJTI'] = $checkJTI;
        $self['createdAt'] = $createdAt;
        $self['createdByActorID'] = $createdByActorID;
        $self['issuerURL'] = $issuerURL;
        $self['jwks'] = $jwks;
        $self['jwksPollingDisabledAt'] = $jwksPollingDisabledAt;
        $self['maxJWTLifetimeSeconds'] = $maxJWTLifetimeSeconds;
        $self['name'] = $name;
        $self['pollStatus'] = $pollStatus;
        $self['updatedAt'] = $updatedAt;
        $self['updatedByActorID'] = $updatedByActorID;

        return $self;
    }

    /**
     * Tagged ID of the federation issuer.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * If set, all rules referencing this issuer reject token exchange.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that archived this issuer.
     */
    public function withArchivedByActorID(?string $archivedByActorID): self
    {
        $self = clone $this;
        $self['archivedByActorID'] = $archivedByActorID;

        return $self;
    }

    /**
     * Whether the jwt-bearer exchange enforces JTI single-use (replay protection) for tokens from this issuer. Applies only to assertions carrying a `jti` claim; tokens without one are accepted without single-use enforcement.
     */
    public function withCheckJTI(bool $checkJTI): self
    {
        $self = clone $this;
        $self['checkJTI'] = $checkJTI;

        return $self;
    }

    /**
     * When this issuer was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that created this issuer.
     */
    public function withCreatedByActorID(?string $createdByActorID): self
    {
        $self = clone $this;
        $self['createdByActorID'] = $createdByActorID;

        return $self;
    }

    /**
     * The `iss` claim value. Incoming JWTs must match exactly.
     */
    public function withIssuerURL(string $issuerURL): self
    {
        $self = clone $this;
        $self['issuerURL'] = $issuerURL;

        return $self;
    }

    /**
     * How signing keys are obtained for signature verification.
     *
     * @param JWKSShape $jwks
     */
    public function withJWKS(
        JWKSDiscovery|array|JWKSExplicitURL|JWKSInline $jwks
    ): self {
        $self = clone $this;
        $self['jwks'] = $jwks;

        return $self;
    }

    /**
     * If set, Anthropic's JWKS poller has paused polling for this issuer after repeated fetch failures. Re-enable by sending `jwks_polling_disabled: false` via the issuer update endpoint (POST) once the upstream JWKS endpoint is fixed. An OAuth caller cannot send this when the issuer backs a rule with any scope other than `workspace:developer` or `workspace:inference`; use a Console session.
     */
    public function withJWKSPollingDisabledAt(
        ?\DateTimeInterface $jwksPollingDisabledAt
    ): self {
        $self = clone $this;
        $self['jwksPollingDisabledAt'] = $jwksPollingDisabledAt;

        return $self;
    }

    /**
     * Maximum allowed iat→exp spread for assertions from this issuer (1-176400 seconds, i.e. up to 49h). Assertions must carry both `iat` and `exp`; a missing `iat` is rejected.
     */
    public function withMaxJWTLifetimeSeconds(int $maxJWTLifetimeSeconds): self
    {
        $self = clone $this;
        $self['maxJWTLifetimeSeconds'] = $maxJWTLifetimeSeconds;

        return $self;
    }

    /**
     * Admin-chosen slug identifier.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Live state of Anthropic's JWKS polling for this issuer. Populated on both single-issuer retrieval and list responses, including archived issuers. Typically null for inline-key issuers (no polling), or when poll status is temporarily unavailable or polling has not started yet.
     *
     * @param FederationIssuerPollStatus|FederationIssuerPollStatusShape|null $pollStatus
     */
    public function withPollStatus(
        FederationIssuerPollStatus|array|null $pollStatus
    ): self {
        $self = clone $this;
        $self['pollStatus'] = $pollStatus;

        return $self;
    }

    /**
     * @param 'federation_issuer' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When this issuer was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that last updated this issuer.
     */
    public function withUpdatedByActorID(?string $updatedByActorID): self
    {
        $self = clone $this;
        $self['updatedByActorID'] = $updatedByActorID;

        return $self;
    }
}
