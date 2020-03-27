<?php


namespace Khamsolt\Laravi18\Controllers;


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

    /**
     * I18nController constructor.
     * @param TranslationInterface $translation
     */
    public function __construct(TranslationInterface $translation)
    {
        $this->translation = $translation;
    }

    /**
     * @return JsonResponse
     */
    public function translations()
    {
        $collection = $this->translation->getCollection();
        return Response::json($collection);
    }
}
