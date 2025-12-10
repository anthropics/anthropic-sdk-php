<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaMetadataShape = array{userID?: string|null}
 */
final class BetaMetadata implements BaseModel
{
    /** @use SdkModel<BetaMetadataShape> */
    use SdkModel;

    /**
     * An external identifier for the user who is associated with the request.
     *
     * This should be a uuid, hash value, or other opaque identifier. Anthropic may use this id to help detect abuse. Do not include any identifying information such as name, email address, or phone number.
     */
    #[Optional('user_id', nullable: true)]
    public ?string $userID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $userID = null): self
    {
        $obj = new self;

        null !== $userID && $obj['userID'] = $userID;

        return $obj;
    }

    /**
     * An external identifier for the user who is associated with the request.
     *
     * This should be a uuid, hash value, or other opaque identifier. Anthropic may use this id to help detect abuse. Do not include any identifying information such as name, email address, or phone number.
     */
    public function withUserID(?string $userID): self
    {
        $obj = clone $this;
        $obj['userID'] = $userID;

        return $obj;
    }
}
