<?php

namespace App\Listeners;

use App\Jobs\ScheduleProductBidEnds;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductCreatedListener
{
    protected Schedule $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }


    public function scheduleProduct(mixed $event): void
    {
        $this->schedule->job(new ScheduleProductBidEnds)->everyTwoSeconds();
    }
}
