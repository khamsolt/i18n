<?php


namespace Khamsolt\Laravi18\Services;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Translation\Translator;
use Khamsolt\Laravi18\Contracts\Services\TranslationInterface;

/**
 * Class TranslationServices
 * @package Khamsolt\I18n\Services
 */
class TranslationServices implements TranslationInterface
{
    /** @var Translator */
    private $translator;
    /** @var Filesystem */
    private $filesystem;

    /**
     * TranslationServices constructor.
     * @param Translator $translator
     * @param Filesystem $filesystem
     */
    public function __construct(Translator $translator, Filesystem $filesystem)
    {
        $this->translator = $translator;
        $this->filesystem = $filesystem;
    }

    /**
     * Get the translations.
     *
     * @return Collection
     */
    public function getCollection(): Collection
    {
        $translations = collect($this->filesystem->directories(resource_path('lang')))
            ->mapWithKeys(function ($dir) {
                return [
                    basename($dir) => collect($this->getFiles($dir))->flatMap(function ($file) {
                        return [
                            $file->getBasename('.php') => (include $file->getPathname()),
                        ];
                    }),
                ];
            });
        $packageTranslations = $this->packageTranslations();

        return $translations->keys()
            ->merge($packageTranslations->keys())
            ->unique()
            ->values()
            ->mapWithKeys(function ($locale) use ($translations, $packageTranslations) {
                return [
                    $locale => $translations->has($locale)
                        ? $translations->get($locale)
                            ->merge($packageTranslations->get($locale))
                        : $packageTranslations->get($locale)
                            ->merge($translations->get(config('app.fallback_locale'))),
                ];
            });
    }

    /**
     * Get the package translations.
     *
     * @return Collection
     */
    protected function packageTranslations(): Collection
    {
        $namespaces = $this->translator->getLoader()->namespaces();
        return collect($namespaces)
            ->map(function ($dir, $namespace) {
                return collect($this->filesystem->directories($dir))->flatMap(function ($dir) use ($namespace) {
                    return [
                        basename($dir) => collect([
                            $namespace . '::' => collect($this->getFiles($dir))->flatMap(function ($file) {
                                return [
                                    $file->getBasename('.php') => (include $file->getPathname()),
                                ];
                            })->toArray(),
                        ]),
                    ];
                });
            })
            ->reduce(function ($collection, $item) {
                return $collection->mergeRecursive($item);
            }, collect());
    }

    /**
     * Get the files of the given directory.
     *
     * @param string $dir
     * @return array
     */
    protected function getFiles($dir): array
    {
        if (is_dir($dir)) {
            return $this->filesystem->files($dir);
        }
        return [];
    }
}
