<?php

namespace App\Filament;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\TextColor;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ComponentHelper
{

    const CURRENCY_LEFT = 1;
    const CURRENCY_RIGHT = 2;

    private function __construct() {/** No need to instantiate obj */}

    public static array $acceptImages = ['image/png', 'image/jpg', 'image/jpeg'];

    public static int $maxFileSize = 1024 * 1024 * 5; // 5M

    public static int $maxFiles = 6;

    public static function richEditor($name) {
        return RichEditor::make($name)
            ->extraAttributes(['style' => 'min-height: calc(24px * 5);'])
            ->toolbarButtons([
                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                ['table', 'attachFiles'],
                ['undo', 'redo'],
            ])
            ->mergeTags([
                'current' => date('Y-m-d h:i:s'),
                'today' => date('Y-m-d'),
            ])
            ->fileAttachmentsAcceptedFileTypes(self::$acceptImages)
            ->fileAttachmentsMaxSize(1024 * 1024 * 2) // 2M
            ->textColors([
                '#ef4444' => 'Red',
                '#10b981' => 'Green',
                '#0ea5e9' => 'Sky',
                ...TextColor::getDefaults()
            ])
            ->columnSpanFull();
    }

    public static function fileUpload($name) {
        return FileUpload::make($name)
            ->maxFiles(self::$maxFiles)
            ->maxSize(self::$maxFileSize)
            ->disk('public')
            ->directory('images')
            ->storeFileNamesIn($name . '_original_name')
            ->getUploadedFileNameForStorageUsing(fn (TemporaryUploadedFile $file) : string =>
                str($file->getClientOriginalName())->prepend(time() . Str::random(1) . '_')->toString()
            )
            ->moveFiles()
            ->deletable()
            ->fetchFileInformation(false)
            ->acceptedFileTypes(self::$acceptImages);
    }

    public static function numeric($name, $isAllowNegative = false) {
        $component = TextInput::make($name)
            ->numeric();
        if (!$isAllowNegative) {
            $component->minValue(0);
        }
        return $component;
    }

    public static function link($name, $domain = null) {
        return TextInput::make($name)
            ->activeUrl()
            ->rules([
                function ($attribute, $value, $fail) use ($domain) {
                    $fragments = parse_url($value);
                    if ($domain !== null && !preg_match($domain,
                            $fragments['host'] . ($fragments['port'] !== null ? ':' . $fragments['port'] : ''))) {
                        $fail('The domain was not match');
                    }
                }
            ]);
    }

    public static function repeater(string $name, array|Field|\Closure $components) {
        if (is_callable($components)) {
            $components = $components();
        } elseif ($components instanceof Field) {
            $components = [$components];
        }
        return Repeater::make($name)->schema($components)
            ->addable()
            ->deletable()
            ->reorderableWithDragAndDrop();
    }

    public static function renderImage($name) {
        return ImageColumn::make($name)
            ->disk('public')
            ->checkFileExistence(false);
    }

    public static function renderCurrency($name, $decimal = 2, $divideBy = 0, $currency = '$', $direction = self::CURRENCY_LEFT) {
        return TextColumn::make($name)
            ->formatStateUsing(function (string $state) use ($decimal, $divideBy, $direction, $currency) {
                if ($direction === self::CURRENCY_RIGHT) {
                    return number_format($currency, $decimal) . " " . $currency;
                }
                $value = (float)$state;
                if ($divideBy != 0) {
                    $value = $value / $divideBy;
                }
                return $currency . " " . number_format($value, $decimal);
            });
    }
}
