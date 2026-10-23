<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type AnalyticsFederatedActorAWSProviderShape = array{
 *   accountID: string, signedPrincipal: string, type: 'aws'
 * }
 */
final class AnalyticsFederatedActorAWSProvider implements BaseModel
{
    /** @use SdkModel<AnalyticsFederatedActorAWSProviderShape> */
    use SdkModel;

    /** @var 'aws' $type */
    #[Required(type: new ConstantOf('aws'))]
    public string $type = 'aws';

    /**
     * The AWS account the organization is bound to.
     */
    #[Required('account_id')]
    public string $accountID;

    /**
     * The AWS-signed ARN of the IAM principal that made the requests.
     */
    #[Required('signed_principal')]
    public string $signedPrincipal;

    /**
     * `new AnalyticsFederatedActorAWSProvider()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsFederatedActorAWSProvider::with(accountID: ..., signedPrincipal: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsFederatedActorAWSProvider())
     *   ->withAccountID(...)
     *   ->withSignedPrincipal(...)
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
     */
    public static function with(
        string $accountID,
        string $signedPrincipal
    ): self {
        $self = new self;

        $self['accountID'] = $accountID;
        $self['signedPrincipal'] = $signedPrincipal;

        return $self;
    }

    /**
     * The AWS account the organization is bound to.
     */
    public function withAccountID(string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    /**
     * The AWS-signed ARN of the IAM principal that made the requests.
     */
    public function withSignedPrincipal(string $signedPrincipal): self
    {
        $self = clone $this;
        $self['signedPrincipal'] = $signedPrincipal;

        return $self;
    }

    /**
     * @param 'aws' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
