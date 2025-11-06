<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateTranslateLanguage extends Command
{
    private $json_template = "{\n}\n";
    private $php_template = "<?php\n\nreturn [\n];\n";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:create {--T|type=php} {--L|lang=en} {--N|name=messages} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use to create template language in directory lang';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $supported_locales = array_keys(config('laravellocalization.supportedLocales'));
        $type = $this->option('type');
        $language = $this->option('lang');
        $name = preg_replace('/[^a-zA-Z0-9]/', '_', $this->option('name'));
        $root = trim(app_path('../lang'), " \n\r\t\v\0/");
        if (!is_dir($root)) {
            Artisan::call('lang:publish');
        }

        if (!in_array($language, $supported_locales) && !$this->hasOption('all')) {
            $this->warn("Please enable locales in config/laravellocalization for " . $language);
            return;
        }


        if (!in_array(strtolower($type), ['php', 'json'])){
            $this->error("Invalid type (php or json)");
        }

        $languages = !$this->hasOption('all') ? [$language] : $supported_locales;

        foreach ($languages as $lang) {
            if (strtolower($type) == 'php') {
                if (!is_dir($root . '/' . $lang)) {
                    mkdir($root . '/' . $lang);
                }
                if (!file_exists($root . '/' . $lang . '/' . $name . '.php')) {
                    file_put_contents($root . '/' . $lang . '/' . $name . '.php', $this->php_template);
                }
            } elseif (strtolower($type) == 'json') {
                if (!file_exists($root . '/' . $lang . '.json')) {
                    file_put_contents($root . '/' . $lang . '.json', $this->json_template);
                }
            }
        }
    }


}
