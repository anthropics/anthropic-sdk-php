<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An AWS IAM role principal.
 *
 * @phpstan-type BetaManagedAgentsAWSRoleExecutionIdentityParamsShape = array{
 *   roleARN: string, type: 'aws_role'
 * }
 */
final class BetaManagedAgentsAWSRoleExecutionIdentityParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAWSRoleExecutionIdentityParamsShape> */
    use SdkModel;

    /** @var 'aws_role' $type */
    #[Required(type: new ConstantOf('aws_role'))]
    public string $type = 'aws_role';

    /**
     * The IAM role's ARN, e.g. "arn:aws:iam::123456789012:role/my-agent-runner". Maximum 2048 characters.
     */
    #[Required('role_arn')]
    public string $roleARN;

    /**
     * `new BetaManagedAgentsAWSRoleExecutionIdentityParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAWSRoleExecutionIdentityParams::with(roleARN: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAWSRoleExecutionIdentityParams())->withRoleARN(...)
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
    public static function with(string $roleARN): self
    {
        $self = new self;

        $self['roleARN'] = $roleARN;

        return $self;
    }

    /**
     * The IAM role's ARN, e.g. "arn:aws:iam::123456789012:role/my-agent-runner". Maximum 2048 characters.
     */
    public function withRoleARN(string $roleARN): self
    {
        $self = clone $this;
        $self['roleARN'] = $roleARN;

        return $self;
    }

    /**
     * @param 'aws_role' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
