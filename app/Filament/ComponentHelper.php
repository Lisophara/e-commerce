<?php

namespace App\Filament;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\TextColor;
use Filament\Forms\Components\TextInput;

class ComponentHelper
{
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
            ]);
    }

    public static function fileUpload($name) {
        return FileUpload::make($name)
            ->maxFiles(self::$maxFiles)
            ->maxSize(self::$maxFileSize)
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
}
