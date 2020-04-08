<?php


namespace Khamsolt\Laravi18\Contracts\Services;


use Illuminate\Support\Collection;

/**
 * Interface TranslationInterface
 * @package Khamsolt\I18n\Contracts\Services
 */
interface TranslationInterface
{
    public const KEY = 'laravi18_translations';

    public function getCollection(): Collection;
}
