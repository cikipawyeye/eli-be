<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SortLanguageKeys extends Command
{
    protected $signature = 'app:sort-language-keys';

    protected $description = 'Sort Language Keys';

    public function handle(): void
    {
        foreach (['en', 'id'] as $locale) {
            $arr = include base_path('lang/'.$locale.'/app.php');
            $this->sortRecursively($arr);

            $content = "<?php\n\nreturn ".var_export($arr, true).";\n";
            file_put_contents(base_path('lang/'.$locale.'/app.php'), $content);
        }

        exec('vendor/bin/pint lang');

        $this->call(GenerateTranslationKeys::class);
    }

    private function sortRecursively(&$array): void
    {
        ksort($array);
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->sortRecursively($value);
            }
        }
    }
}
