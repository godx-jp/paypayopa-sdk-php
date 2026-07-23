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
    "godx-jp/paypayopa-php-sdk": "^2.0"
  }
}
```

Track upstream releases periodically; merge security fixes from PayPay when published.
