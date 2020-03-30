<?php


namespace Khamsolt\Laravi18\Commands;


use Illuminate\Console\Command;
use Khamsolt\Laravi18\Contracts\Services\TranslationInterface as TranslationService;

class Laravi18Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravi18:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache translations keys';

    /**
     * @var TranslationService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @param TranslationService $service
     */
    public function __construct(TranslationService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo 'This is laravi18 package' . PHP_EOL;
    }
}
