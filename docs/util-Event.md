# [Utilities](util.md) / Event
 > im\util\Event
____

## Description
An event object for the `im\util\EventHandler`

## Synopsis
```php
class Event {

    // Properties
    public int $flag
    public im\util\EventHandler $target
    public string $subject = NULL
    public mixed $data = NULL
    public mixed $meta = NULL

    // Methods
    public __construct(int $flag, im\util\EventHandler $target, null|string $subject = NULL, mixed $data = NULL, mixed $meta = NULL, bool $recursive = FALSE)
}
```

## Properties
| Name | Description |
| :--- | :---------- |
| [__Event&nbsp;::&nbsp;$flag__](util-Event-var_flag.md) | The event flag that defines the type of event this is |
| [__Event&nbsp;::&nbsp;$target__](util-Event-var_target.md) | The event handler that triggered this event |
| [__Event&nbsp;::&nbsp;$subject__](util-Event-var_subject.md) | An optional subject for this event |
| [__Event&nbsp;::&nbsp;$data__](util-Event-var_data.md) | Optional data that can be attached to the event |
| [__Event&nbsp;::&nbsp;$meta__](util-Event-var_meta.md) | Additional information that can be attached to the event |

## Methods
| Name | Description |
| :--- | :---------- |
| [__Event&nbsp;::&nbsp;\_\_construct__](util-Event-__construct.md) |  |
