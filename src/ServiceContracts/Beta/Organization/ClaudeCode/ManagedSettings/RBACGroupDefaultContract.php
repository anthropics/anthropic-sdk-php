<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\BetaRequestBodyTimeoutException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaCMEKFeatureUnsupportedException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsDocumentLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\BetaSettingsHistoryLimitExceededException;
use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefault\BetaClaudeCodeRBACGroupDefaultManagedSettings;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;
use Anthropic\SandboxEgressRestrictedException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RBACGroupDefaultContract
{
    /**
     * @api
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws APIException
     */
    public function retrieve(
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null
    ): BetaClaudeCodeRBACGroupDefaultManagedSettings;

    /**
     * @api
     *
     * @param array<string,mixed>|null $settings Body param: The whole settings document, a JSON object of Claude Code managed settings. It replaces any stored document, or `null` clears the default settings. At most 1 MiB as the server stores it, which can be larger than the request body.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `ce-claude-code-managed-settings-2026-10-06` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws BetaCMEKFeatureUnsupportedException
     * @throws CMEKKeyDisabledException
     * @throws BetaRequestBodyTimeoutException
     * @throws BetaSettingsDocumentLimitExceededException
     * @throws BetaSettingsHistoryLimitExceededException
     * @throws SandboxEgressRestrictedException
     * @throws APIException
     */
    public function update(
        ?array $settings,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeCodeRBACGroupDefaultManagedSettings;
}
