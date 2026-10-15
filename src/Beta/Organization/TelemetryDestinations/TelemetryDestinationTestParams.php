<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Send one test span, named `anthropic.test`, to the destination with its registered headers, once and without retries, and report the destination's answer. The response is 200 whether or not the destination answered with a 2xx status: its `result` has the type `success`, or the type `failure` and the reason in `error`. The destination's configuration, `state` and `delivery_health` do not change. A disabled destination can be tested too. Wait 10 seconds between tests of one destination; a request that comes sooner may be answered with status 429.
 *
 * @see Anthropic\Services\Beta\Organization\TelemetryDestinationsService::test()
 *
 * @phpstan-type TelemetryDestinationTestParamsShape = array{
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null
 * }
 */
final class TelemetryDestinationTestParams implements BaseModel
{
    /** @use SdkModel<TelemetryDestinationTestParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header.
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
     * This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header.
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
