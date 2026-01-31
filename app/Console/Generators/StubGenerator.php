<?php

namespace App\Console\Generators;

class StubGenerator
{
    public static function render(string $stub, array $replacements): string
    {
        $content = file_get_contents($stub);

        foreach ($replacements as $key => $value) {
            $content = str_replace(
                '{{ ' . $key . ' }}',
                $value,
                $content
            );
        }

        return $content;
    }
}
