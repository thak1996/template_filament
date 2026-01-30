<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Support\Arr;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        $locales = ['pt_BR', 'en'];
        $data = [];

        foreach ($locales as $locale) {
            $path = lang_path($locale);

            if (!File::exists($path)) {
                continue;
            }

            $files = File::files($path);

            foreach ($files as $file) {
                $group = $file->getFilenameWithoutExtension();
                $translations = include $file->getPathname();

                if (is_array($translations)) {
                    $flattened = Arr::dot($translations);

                    foreach ($flattened as $key => $text) {
                        if (is_string($text)) {
                            $data[$group][$key][$locale] = $text;
                        }
                    }
                }
            }
        }

        foreach ($data as $group => $keys) {
            foreach ($keys as $key => $localesData) {
                LanguageLine::updateOrCreate(
                    [
                        'group' => $group,
                        'key'   => $key,
                    ],
                    [
                        'text' => $localesData
                    ]
                );
            }
        }
    }
}
