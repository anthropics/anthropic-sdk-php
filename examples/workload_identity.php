#!/usr/bin/env php

<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Lib\Credentials\CredentialResult;
use Anthropic\Lib\Credentials\DefaultCredentials;
use Anthropic\Lib\Credentials\IdentityTokenFile;
use Anthropic\Lib\Credentials\StaticToken;
use Anthropic\Lib\Credentials\TokenCache;
use Anthropic\Lib\Credentials\WorkloadIdentityCredentials;

// -------------------------------------------------------------------
// Option 1: Explicit workload identity credentials
// -------------------------------------------------------------------
// Use this when you know the exact federation rule and identity token source.
// Set these environment variables or provide values directly:
//   ANTHROPIC_IDENTITY_TOKEN_FILE - path to OIDC JWT file (e.g., from Kubernetes projected volume)
//   ANTHROPIC_FEDERATION_RULE_ID  - federation rule ID (e.g., fdrl_01...)
//   ANTHROPIC_ORGANIZATION_ID     - organization UUID
//   ANTHROPIC_SERVICE_ACCOUNT_ID  - optional service account ID (e.g., svac_01...)

// $credentials = new CredentialResult(
//     provider: new TokenCache(
//         new WorkloadIdentityCredentials(
//             identityProvider: new IdentityTokenFile('/var/run/tokens/oidc-jwt'),
//             federationRuleId: 'fdrl_01example',
//             organizationId: '00000000-0000-0000-0000-000000000000',
//         ),
//     ),
// );
// $client = new Client(credentials: $credentials);

// -------------------------------------------------------------------
// Option 2: Auto-resolved credentials from environment / config files
// -------------------------------------------------------------------
// Checks ANTHROPIC_API_KEY, ANTHROPIC_AUTH_TOKEN, config profiles, and
// environment variables in order. Returns null if API key auth should be used.
//
// Config profiles live in:
//   Linux/macOS: ~/.config/anthropic/configs/<profile>.json
//   Windows:     %APPDATA%\Anthropic\configs\<profile>.json

$result = DefaultCredentials::resolve();
if (is_null($result)) {
    fwrite(STDERR,
        "No OIDC credentials resolved. Set ANTHROPIC_FEDERATION_RULE_ID and "
        ."ANTHROPIC_IDENTITY_TOKEN_FILE (or ANTHROPIC_IDENTITY_TOKEN) to use workload identity, "
        ."or configure a profile in ~/.config/anthropic/.\n"
    );
    exit(1);
}

$client = new Client(credentials: $result);

// -------------------------------------------------------------------
// Option 3: Static bearer token
// -------------------------------------------------------------------
// If you already have an access token (e.g., from a CLI login):
// $client = new Client(credentials: new CredentialResult(
//     provider: new TokenCache(new StaticToken('sk-ant-oat01-...')),
// ));

$message = $client->messages->create(
    maxTokens: 2048,
    messages: [['role' => 'user', 'content' => 'Tell me a story about building the best SDK!']],
    model: 'claude-sonnet-4-5',
);

echo $message->content[0]->text ?? '';
echo "\n";

$client->close();
