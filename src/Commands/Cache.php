<?php


namespace Khamsolt\Laravi18\Commands;


use Illuminate\Cache\Repository as LaravelCache;
use Illuminate\Console\Command;
use Khamsolt\Laravi18\Contracts\Services\TranslationInterface as TranslationService;

class Cache extends Command
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
     * Create a new command instance.
     *
     * @param TranslationService $service
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param TranslationService $service
     * @param LaravelCache $cache
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function handle(TranslationService $service, LaravelCache $cache)
    {
        $this->info('Laravi18: ');
        $collection = $service->getCollection();
        if ($cache->has($service::KEY) && $cache->delete($service::KEY)) {
            $this->info('Old cache was been removed!');
        }
        if ($cache->add($service::KEY, $collection)) {
            $this->info('Translations have been added to the cache!');
        }
    }
}
