<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_metadata_alias = array{userID?: string|null}
 */
final class BetaMetadata implements BaseModel
{
    use Model;

    /**
     * An external identifier for the user who is associated with the request.
     *
     * This should be a uuid, hash value, or other opaque identifier. Anthropic may use this id to help detect abuse. Do not include any identifying information such as name, email address, or phone number.
     */
    #[Api('user_id', optional: true)]
    public ?string $userID;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(?string $userID = null)
    {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $userID && $this->userID = $userID;
    }
}
