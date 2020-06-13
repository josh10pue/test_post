<?php

namespace App\Console\Commands;

use App\Exceptions\PostException;
use App\Jobs\RequestExamples;
use App\Models\Example;
use App\Models\Response;
use App\Traits\Guzzle;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendPostQueue extends Command
{
    use Guzzle;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-post:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send post to check commands and queues';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //the variable "QUEUE_CONNECTION" must be set in database before run this command
        $example = Example::inRandomOrder()
                          ->limit(rand(1,1000))  // the seeder generate only 1k for this example
                          ->get();

        if(count($example) > 1){
            $chunk = $example->chunk(100);//you can change it depending on the requirement
            $chunk->toArray();

            foreach ($chunk as $item) {
                RequestExamples::dispatch($item);
            }

            $this->info('the requests will be processed');
            return;
        }

        $progressBar = $this->output->createProgressBar(count($example));

        $this->process($example[0]->path);

        $progressBar->advance();
        $progressBar->finish();
    }
}
