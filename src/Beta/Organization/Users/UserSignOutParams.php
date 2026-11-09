<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Sign a member out of Claude everywhere, without removing them from the organization. This ends their sign-in sessions and removes their trusted devices wherever they use Claude, including other organizations and individual plans. It also ends the OAuth tokens issued to them for this organization, so apps such as Claude Code must sign in again.
 *
 * A token can take up to an hour to stop working, though it almost always stops at once. The member keeps their role and can sign in again right away. To keep them out, remove them from the organization or, if your organization uses single sign-on, block them in your identity provider. Signing out does not end API keys, OAuth tokens that were not issued for this organization, or the member's Claude Code cloud sessions and routines.
 *
 * You cannot sign out the organization's primary owner or the person your API key or token acts for, and a request to sign out another owner, a member with owner permissions, or a membership admin may be refused. A refused request returns a `400` or `403` error that says why. If the request returns `503`, send it again to finish; anything already ended stays ended.
 *
 * Every request must include the beta header `anthropic-beta: admin-user-sign-out-2026-10-08`. A request without it returns `400`. Sign-out is in beta for Claude Enterprise organizations. In an organization where it is not enabled, a request returns `400` with `error_code` `organization_not_enrolled_in_beta`. In a Claude Enterprise organization, an API key needs the `write:members` scope; a key without it gets `403`.
 *
 * @see Anthropic\Services\Beta\Organization\UsersService::signOut()
 *
 * @phpstan-type UserSignOutParamsShape = array{
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null
 * }
 */
final class UserSignOutParams implements BaseModel
{
    /** @use SdkModel<UserSignOutParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * This endpoint is in beta: requests must send `admin-user-sign-out-2026-10-08` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(?array $betas = null): self
    {
        $self = new self;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `admin-user-sign-out-2026-10-08` in this header.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
