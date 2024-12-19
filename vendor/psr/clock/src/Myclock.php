<?php


namespace Psr\Clock;

use DateTimeImmutable;


class Myclock implements ClockInterface
{
    /**
     * Returns the current time as a DateTimeImmutable object.
     *
     * @return DateTimeImmutable
     */
    public function now(): DateTimeImmutable
    {
        return new \DateTimeImmutable(); 
    }
}

?>