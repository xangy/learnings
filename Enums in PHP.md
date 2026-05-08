---
topic: Foundation Reset - PHP 8.x + OOP Fundamentals
date: 06-05-2026
tags:
  - php
  - enums
preparation-notes: Backed enums (string/int), pure enums, methods on enums (label(), canTransitionTo()), implementing interfaces. Write OrderStatus backed enum with full state-machine
---
Enums can be of two type: pure and backed enums.

Pure enums are used when you don't need to save the values in the database. They are only meant to be used in the realm of the code.

e.g.
```
enum NodeStatus
{
	case Draft;
	case Published;
}
 
// Usage.
function changeNodeStatus(Node $node, NodeStatus $status)
{
	if ($status === NodeStatus::Published) {
		$node->sendEmailToEditor();
	}
}

changeNodeStatus($node, NodeStatus::Draft); // works and type is enforced.

changeNodeStatus($node, 'published'); // fails as string is of not enum, NodeStatus, type.
```

Backed enums are used when you want to save some values to the database.
e.g.
```
enum UserStatus: string
{
	case Active = 'active';
	case Blocked = 'blocked';
	case Suspended = 'suspended';
}

enum UserRole: int
{
	case Authenticate = 1;
	case Anonymous = 0;
}

// Checking if other types work or not.
// Doesn't work Enum backing type can only be string or int.
enum Rating: float
{
	case Good = 3.0;
}
```

To fetch enum constants from its string or int values, you can use `Enum::from()` or `Enum::tryFrom()` as follows:
```
$userStatus = UserStatus::from('active'); // throws error if invalid.

$userStatus = UserStatus::tryFrom('blocked'); // returns null if invalid.
```

Use enum constant, they need to have constant value defined (if any). The enum values can't be calculate on runtime.

The enums can have method, static methods, use traits, and can implement interfaces.

NOTE: Think of using enums for following cases:
- replacing string constants - when you see a string being used in the database, consider using enum constants. e.g in querying the database with where clause.
- as policy object - for small system/sub-system, you can use enums to define the policy constants and methods to implement the policy within the enum.
- as safe deserialization of data from user/API/database - you can consider using Enum's tryFrom() method to check if the data actually is valid or not.


## Related Topics
- [[]]