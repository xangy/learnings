<?php

// Pure enums when you don't need the values to be saved in the database. The purpose on this enum is to be used on in the code.
enum NodeStatus
{
    case Draft;
    case Published;
}

// Usage
function changeNodeStatus(Node $node, NodeStatus $status)
{
    if ($status === NodeStatus::Published) {
        $node->sendEmailToEditor();
    }
}

changeNodeStatus($node, NodeStatus::Draft); // works and type is enforced.
changeNodeStatus($node, 'published'); // fails as string is of not enum, NodeStatus, type.


// Backed enums when you need to save the values in the database. we can use string or int values.

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

// Checking if other types work or not
enum Rating: float // Doesn't work Enum backing type can only be string or int.
{
    case Good = 3.0;
}

$userStatus = UserStatus::from('active'); // throws error if invalid.

$userStatus = UserStatus::tryFrom('blocked') ?? UserStatus::Blocked; // returns null if invalid.


enum OrderStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Shipped = 'shipped';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match($this) {
            OrderStatus::Pending => 'Awaiting confirmation',
            OrderStatus::Confirmed => 'Order has been confirmed',
            OrderStatus::Shipped => 'Order has been shipped',
            OrderStatus::Cancelled => 'Order has been cancelled',
        };
    }

    public function canTransitionTo(OrderStatus $nextStatus): bool
    {
        return match($this) {
            OrderStatus::Pending => $nextStatus === OrderStatus::Confirmed || $nextStatus === OrderStatus::Cancelled,
            OrderStatus::Confirmed => $nextStatus === OrderStatus::Shipped || $nextStatus === OrderStatus::Cancelled,
            OrderStatus::Shipped => false,
            OrderStatus::Cancelled => false,
        };
    }

    public function isFinal(OrderStatus $order): bool
    {
        return match($this) {
            OrderStatus::Shipped, OrderStatus::Cancelled => true,
            default => false,
        };
    }
}