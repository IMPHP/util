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

/**
 * Defines a binary event handler.
 *
 * This event handler uses binary event flags to define
 * each event type. That means that each event type must be defined
 * as `$event = 1 << $x`.
 *
 * The event handler defines classes that provides events for internal
 * tasks. It is not meant to be a global handler and as such it does not define
 * any external dispatch features. Dispatching is an internal matter and the classes
 * only provide external callback feature on events.
 */
interface EventHandler {

    /**
     * Set a new event listener on this handler.
     *
     * @note
     *      You can "pipe" events together to add one listener on multiple events
     *      like `event1|event2`.
     *
     * @param $listener
     *      The listener that will be called on the registered events
     */
    function setEventListener(int $events, callable|EventListener $listener): void;
}
