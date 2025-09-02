<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type metadata_alias = array{userID?: string|null}
 */
final class Metadata implements BaseModel
{
    /** @use SdkModel<metadata_alias> */
    use SdkModel;

    /**
     * An external identifier for the user who is associated with the request.
     *
     * This should be a uuid, hash value, or other opaque identifier. Anthropic may use this id to help detect abuse. Do not include any identifying information such as name, email address, or phone number.
     */
    #[Api('user_id', nullable: true, optional: true)]
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

        null !== $userID && $obj->userID = $userID;

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
        $obj->userID = $userID;

        return $obj;
    }
}
