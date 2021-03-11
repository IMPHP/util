# [Utilities](util.md) / EventHandler
 > im\util\EventHandler
____

## Description
Defines a binary event handler.

This event handler uses binary event flags to define
each event type. That means that each event type must be defined
as `$event = 1 << $x`.

The event handler defines classes that provides events for internal
tasks. It is not meant to be a global handler and as such it does not define
any external dispatch features. Dispatching is an internal matter and the classes
only provide external callback feature on events.

## Synopsis
```php
interface EventHandler {

    // Methods
    setEventListener(int $events, im\util\EventListener|callable $listener): void
}
```

## Methods
| Name | Description |
| :--- | :---------- |
| [__EventHandler&nbsp;::&nbsp;setEventListener__](util-EventHandler-setEventListener.md) | Set a new event listener on this handler |
