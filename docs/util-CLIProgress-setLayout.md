# [Utilities](util.md) / [CLIProgress](util-CLIProgress.md) :: setLayout
 > im\util\CLIProgress
____

## Description
Change the layout.

| Token      | Description                       |
| ---------- | --------------------------------- |
| :bar:      | The progress bar                  |
| :percent:  | The current percentage            |
| :done:     | Current progress state            |
| :total:    | Total progress to reach           |
| :text:     | The optional text from start()    |

## Synopsis
```php
public setLayout(string $layout): void
```

## Parameters
| Name | Description |
| :--- | :---------- |
| layout | The new layout |

## Example 1
```php
$progress->setLayout(":text: :bar: :percent:% - :done:/:total:");
```
