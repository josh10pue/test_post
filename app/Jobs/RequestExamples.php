<?php

namespace App\Jobs;

use App\Traits\Guzzle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RequestExamples implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Guzzle;

    /**
     * @var \App\Models\Guide
     */
    protected $paths;

    /**
     * ProcessUpdateGuides constructor.
     *
     * @param $guide
     */
    public function __construct($paths)
    {
        $this->paths = $paths;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->paths as $item) {
            $this->process($item->path);
        }
    }
}
