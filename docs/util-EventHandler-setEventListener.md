# [Utilities](util.md) / [EventHandler](util-EventHandler.md) :: setEventListener
 > im\util\EventHandler
____

## Description
Set a new event listener on this handler.

 > You can "pipe" events together to add one listener on multiple events like `event1|event2`.  

## Synopsis
```php
setEventListener(int $events, im\util\EventListener|callable $listener): void
```

## Parameters
| Name | Description |
| :--- | :---------- |
| listener | The listener that will be called on the registered events |
