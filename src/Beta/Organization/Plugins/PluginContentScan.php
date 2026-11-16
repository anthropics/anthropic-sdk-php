<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Beta\Organization\Plugins\PluginContentScan\Assessment;
use Anthropic\Beta\Organization\Plugins\PluginContentScan\Status;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type PluginContentScanShape = array{
 *   assessment: null|Assessment|value-of<Assessment>,
 *   reason: string|null,
 *   status: Status|value-of<Status>,
 * }
 */
final class PluginContentScan implements BaseModel
{
    /** @use SdkModel<PluginContentScanShape> */
    use SdkModel;

    /**
     * The scan's verdict; set only when `status` is `completed`. A `warn` can mean a `fail` that was allowed in claude.ai.
     *
     * @var value-of<Assessment>|null $assessment
     */
    #[Required(enum: Assessment::class)]
    public ?string $assessment;

    /**
     * The primary mechanism behind a `warn` or `fail`, such as `credential-exposure` or `guardrail-tampering`; a mechanism this API does not yet name reads as `other`. Read `status` first: on an `errored` scan it is not a finding but why there is no verdict: `scan-invalid-archive`, the scan refused the version's archive, or could not process it, before checking what its files say, and running it again will not help, so change the files and store a new version; `scan-did-not-finish`, the scan did not finish or its result is no longer available, so retry the scan in claude.ai if it offers a retry; `scan-unavailable`, the scan could not run or its result cannot be read right now, so read the version again later, then retry the scan in claude.ai if it offers a retry. If these steps do not help, contact support. Null on a `pass`, while a scan runs, and when no mechanism is reported for the verdict. On an errored scan, null means that a compliance configuration ruled out the scan.
     */
    #[Required]
    public ?string $reason;

    /**
     * `processing` while a scan runs, `completed` when it ran to completion, `errored` when it could not run. Once a scan of the version has completed, `content_scan` describes the newest completed scan, even while a later scan runs. While the scan outcome cannot be read, `status` is `errored` instead.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * `new PluginContentScan()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginContentScan::with(assessment: ..., reason: ..., status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginContentScan())->withAssessment(...)->withReason(...)->withStatus(...)
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
     * @param Assessment|value-of<Assessment>|null $assessment
     * @param Status|value-of<Status> $status
     */
    public static function with(
        Assessment|string|null $assessment,
        ?string $reason,
        Status|string $status
    ): self {
        $self = new self;

        $self['assessment'] = $assessment;
        $self['reason'] = $reason;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The scan's verdict; set only when `status` is `completed`. A `warn` can mean a `fail` that was allowed in claude.ai.
     *
     * @param Assessment|value-of<Assessment>|null $assessment
     */
    public function withAssessment(Assessment|string|null $assessment): self
    {
        $self = clone $this;
        $self['assessment'] = $assessment;

        return $self;
    }

    /**
     * The primary mechanism behind a `warn` or `fail`, such as `credential-exposure` or `guardrail-tampering`; a mechanism this API does not yet name reads as `other`. Read `status` first: on an `errored` scan it is not a finding but why there is no verdict: `scan-invalid-archive`, the scan refused the version's archive, or could not process it, before checking what its files say, and running it again will not help, so change the files and store a new version; `scan-did-not-finish`, the scan did not finish or its result is no longer available, so retry the scan in claude.ai if it offers a retry; `scan-unavailable`, the scan could not run or its result cannot be read right now, so read the version again later, then retry the scan in claude.ai if it offers a retry. If these steps do not help, contact support. Null on a `pass`, while a scan runs, and when no mechanism is reported for the verdict. On an errored scan, null means that a compliance configuration ruled out the scan.
     */
    public function withReason(?string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * `processing` while a scan runs, `completed` when it ran to completion, `errored` when it could not run. Once a scan of the version has completed, `content_scan` describes the newest completed scan, even while a later scan runs. While the scan outcome cannot be read, `status` is `errored` instead.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
