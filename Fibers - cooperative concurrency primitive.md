---
topic: Foundation Reset - PHP 8.x + OOP Fundamentals
date: 10-05-2026
tags:
  - php
  - concurrency
preparation-notes: Fiber is a pausable function. Fiber::suspend() hands control back to the caller. No built-in scheduler — ReactPHP/AMPHP provide the event loop on top. Compare to JS async/await (runtime-backed) and Go goroutines (pre-emptive scheduler).
---
Fibers are the concurrency primitive for the PHP asynchronous feature. On its own, it is just a pausable function meaning we can pause it using Fiber::suspend(). Though it can't unpause itself and we will have to track the reference and call `->resume()` to resume the function.

Since it's the primitive, we have ReactPHP/AmpPHP which bring a collection of libraries that we can use to write non-blocking I/O operations.  

## Related Topics
- [[]]