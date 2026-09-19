# godx-jp fork of paypayopa/php-sdk

Upstream: https://github.com/paypay/paypayopa-sdk-php

This fork exists because the upstream package constrains `firebase/php-jwt` to `^5.5 || ^6.0`,
which conflicts with `dxs/laravel-auth` (and Laravel 13 stacks) that require `firebase/php-jwt ^7`.

## Changes vs upstream

| Area | Upstream | godx-jp fork |
|------|----------|--------------|
| Package name | `paypayopa/php-sdk` | `godx-jp/paypayopa-php-sdk` |
| PHP | `>=7.0` | `^8.1` |
| firebase/php-jwt | `^5.5 \|\| ^6.0` | `^6.0 \|\| ^7.0` |
| guzzlehttp/guzzle | `^6.0 \|\| ^7.0` | `^7.0` |
| PHPUnit (dev) | ^9 | ^10 |

No PayPay API behaviour changes — JWT usage in `User::decodeUserAuth()` already uses the
`Firebase\JWT\Key` API compatible with php-jwt v7.

## Consumer install (Tempo backend)

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/godx-jp/paypayopa-sdk-php.git"
    }
  ],
    "require": {
    "godx-jp/paypayopa-php-sdk": "^2.1"
  }
```

Release tag: `2.1.0` (first godx-jp release with php-jwt ^7 compatibility).
```

Track upstream releases periodically; merge security fixes from PayPay when published.

## CI on a fork: `disabled_fork`, and the one call that clears it

GitHub disables Actions workflows on a forked repository by default. The workflow file looks
correct, the repository's Actions permissions read `enabled: true, allowed_actions: all`, and yet
**no event triggers anything** — not `push`, not `pull_request`, not `schedule`. Only a manual
`workflow_dispatch` runs, which gates nothing.

The symptom is silence, so it is easy to misread as "CI is fine, nobody has pushed". The way to
see it is to ask for the workflow's state, not the repository's:

```bash
gh api repos/godx-jp/paypayopa-sdk-php/actions/workflows \
  --jq '.workflows[]|"\(.name) state=\(.state)"'
# Paypay PHP SDK CI state=disabled_fork      ← not `active`
```

This cost the CI-standardisation work (issue #1) its acceptance criterion: "3 consecutive green
runs on `master`" cannot happen on its own when no event fires. Every other item in that issue —
`concurrency`, `paths-ignore`, the matrix split, WireMock via `docker cp` — had been done
correctly at `55bed90d` and had simply never run.

**It does not need GitHub Support and it does not need the fork detached.** One call:

```bash
gh api -X PUT repos/godx-jp/paypayopa-sdk-php/actions/workflows/<workflow_id>/enable
# state → active
```

It is reversible with the matching `/disable`. Detaching the fork is still defensible on its own
merits — the relationship is one-way and the package was renamed — but it is not required to get
CI running, and it was previously concluded that it was.

