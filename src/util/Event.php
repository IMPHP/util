<?php declare(strict_types=1);
/*
 * This file is part of the IMPHP Project: https://github.com/IMPHP
 *
 * Copyright (c) 2021 Daniel Bergløv, License: MIT
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO
 * THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
 * THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace im\util;

use Exception;

/**
 * An event object for the `im\util\EventHandler`
 *
 * @var int $flag
 *      The event flag that defines the type of event this is
 *
 * @var im\util\EventHandler $target
 *      The event handler that triggered this event
 *
 * @var string $subject = null
 *      An optional subject for this event
 *
 * @var mixed $data = null
 *      Optional data that can be attached to the event
 *
 * @var mixed $meta = null
 *      Additional information that can be attached to the event
 */
class Event {

    /**
     * @internal
     */
    protected array $props;

    /**
     * @param $flag
     *      The event flag that defines the type of event this is
     *
     * @param $target
     *      The event handler that triggered this event
     *
     * @param $subject
     *      An optional subject for this event
     *
     * @param $data
     *      Optional data that can be attached to the event
     *
     * @param $meta
     *      Additional information that can be attached to the event
     *
     * @param $recursive
     *      Whether recursive calls is allowed on this event.
     *      If not, the event stops propagation after a recursive event. 
     */
    public function __construct(int $flag, EventHandler $target, string $subject = null, mixed $data = null, mixed $meta = null, bool $recursive = false) {
        $this->props = [
            "flag" => $flag,
            "target" => $target,
            "subject" => $subject,
            "data" => $data,
            "meta" => $meta,
            "recursive" => $recursive
        ];
    }

    /**
     * @php
     */
    public function __get(string $name): mixed {
        if (array_key_exists($name, $this->props)) {
            return $this->props[$name];
        }

        throw new Exception("Invalid property name '$name'");
    }
}
