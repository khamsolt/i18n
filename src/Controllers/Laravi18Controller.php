<?php


namespace Khamsolt\Laravi18\Controllers;


use Illuminate\Cache\Repository as Cache;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Khamsolt\Laravi18\Contracts\Services\TranslationInterface;

/**
 * Class I18nController
 * @package Khamsolt\I18n\Controllers
 */
class Laravi18Controller extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var TranslationInterface */
    private $translation;
    /** @var Cache */
    private $cache;
    /** @var Config */
    private $config;

    /**
     * I18nController constructor.
     * @param TranslationInterface $translation
     * @param Cache $cache
     * @param Config $config
     */
    public function __construct(TranslationInterface $translation, Cache $cache, Config $config)
    {
        $this->translation  = $translation;
        $this->cache        = $cache;
        $this->config       = $config;
    }

    /**
     * @return JsonResponse
     */
    public function translations()
    {
        return Response::json($this->cache->get($this->translation::KEY));
    }
}
