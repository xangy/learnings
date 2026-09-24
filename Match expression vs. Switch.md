---
topic: Foundation Reset - PHP 8.x + OOP Fundamentals
date: 09-05-2026
tags:
  - php
  - match
  - switch
preparation-notes: match is an expression (returns a value), uses strict comparison, no fall-through, throws UnhandledMatchError if no arm matches. Rewrite 3 Drupal switch statements. Note why this is safer.
---

|              | match()                                                   | switch()                                            |
| ------------ | --------------------------------------------------------- | --------------------------------------------------- |
| Comparison   | Strict - `===`                                            | Loose - `==`                                        |
| Return value | Returns a value by design                                 | Need to manually add a return statement in the case |
|              | Raises `UnhandledMatchError` error when no match is found | No error                                            |
|              | Need break statement to                                   |                                                     |

```
switch ($response->getStatusCode()) {
    case 301:
        $maxAge = $this->configApe->get('lifetime.301');
        break;
    case 302:
        $maxAge = $this->configApe->get('lifetime.302');
        break;
    case 403:
        $maxAge = 0;
        break;
    case 404:
        $maxAge = $this->configApe->get('lifetime.404');
        break;
}
```

to

```
$maxAge = match($response->getStatusCode()) {
	301 => $this->configApe->get('lifetime.301'),
	302 => $this->configApe->get('lifetime.302'),
	403 => 0,
	404 => $this->configApe->get('lifetime.404'),
	default => $maxAge,
};
```
## Related Topics
- [[]]