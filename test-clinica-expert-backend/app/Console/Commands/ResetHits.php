<?php

namespace App\Console\Commands;

use App\Repositories\ShortLinkRepository;
use Illuminate\Console\Command;

class ResetHits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:hits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset hits of ShortLinks registers';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private ShortLinkRepository $shortLinkRepository)
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
        $this->shortLinkRepository->updateHits();
    }
}
