<?php

namespace Modules\Blocks\Traits;

use Laravel\Pail\Files;
use Modules\Blocks\Filament\Resources\Templates\Button;
use Modules\Blocks\Filament\Resources\Templates\CardList;
use Modules\Blocks\Filament\Resources\Templates\CardWithCounter;
use Modules\Blocks\Filament\Resources\Templates\ColorBackground;
use Modules\Blocks\Filament\Resources\Templates\ColorPickerColor;
use Modules\Blocks\Filament\Resources\Templates\ContainerColorPicker;
use Modules\Blocks\Filament\Resources\Templates\Description;
use Modules\Blocks\Filament\Resources\Templates\DescriptionEditor;
use Modules\Blocks\Filament\Resources\Templates\Faq;
use Modules\Blocks\Filament\Resources\Templates\FaqWithInputs;
use Modules\Blocks\Filament\Resources\Templates\File;
use Modules\Blocks\Filament\Resources\Templates\ImgList;
use Modules\Blocks\Filament\Resources\Templates\ImageWithTitleAndDescription;
use Modules\Blocks\Filament\Resources\Templates\ThreeCartsList;
use Modules\Blocks\Filament\Resources\Templates\TitleWithTwoInputsList;
use Modules\Blocks\Filament\Resources\Templates\TitleWithTwoTitleItem;
use Modules\Blocks\Filament\Resources\Templates\IconTitleDescriptionList;
use Modules\Blocks\Filament\Resources\Templates\Image;
use Modules\Blocks\Filament\Resources\Templates\ImageTitleSubtitleButtonItem;
use Modules\Blocks\Filament\Resources\Templates\KeyValue;
use Modules\Blocks\Filament\Resources\Templates\Services;
use Modules\Blocks\Filament\Resources\Templates\SubTitle;
use Modules\Blocks\Filament\Resources\Templates\TextItem;
use Modules\Blocks\Filament\Resources\Templates\TextList;
use Modules\Blocks\Filament\Resources\Templates\Title;
use Modules\Blocks\Filament\Resources\Templates\TitleDescriptionDescriptionEditorList;
use Modules\Blocks\Filament\Resources\Templates\TitleDescriptionEditorList;
use Modules\Blocks\Filament\Resources\Templates\TitleDescriptionTitleDescriptionList;
use Modules\Blocks\Filament\Resources\Templates\TitleEditorTextList;
use Modules\Blocks\Filament\Resources\Templates\TitleImageIconUrlItem;
use Modules\Blocks\Filament\Resources\Templates\IconTitleSubTitleImageList;
use Modules\Blocks\Filament\Resources\Templates\FileAndTwoTitleList;
use function PHPUnit\Framework\isString;

trait HasBlock
{
    const TEMPLATE_WITH_IMAGE = [
        'image',
        'image-list',
        'image-two',
        'image-third',
        'image-forth',
        'image-five',
        'image-second-block-second',
        'image-second-block-first',
        'image-third-block-third',
        'file',
        'file-two',
        'file-two',
        'service-item',
        'detail-item',
        'imageTitleDescriptionButton-item',
        'cardWithCounter-item',
        'detail-item',
        'icon-title-description-item',
        'title-editor-text-list',
        'titleImageIconUrl-item',
    ];
    const IMAGE_FIELDS = [
        'image',
        'image',
        'image-two',
        'image-third',
        'image-forth',
        'image-five',
        'image-second-block-first',
        'image-second-block-second',
        'image-third-block-third',
        'icon',
        'file',
        'file-two',
    ];

    const TRANSLATABLE_FIELDS = [
        'title',
        'description',
        'title-file',
        'title-first',
        'title-second',
        'title-third',
        'title-forth',
        'title-button',
        'title-button-first',
        'title-block-second-first',
        'title-block-second-second',
        'title-block-second-three',
        'title-block-second-forth',
        'title-block-second-fives',
        'title-block-second-six',
        'title-block-second-sevens',
        'title-button-second',
        'title-button-third',
        'title-block-third-first',
        'title-block-third-second',
        'title-block-third-three',
        'title-block-third-forth',
        'subtitle',
        'description_editor',
        'description',
        'text',
        'answer_text',
        'link',
        'key',
        'value',
        'title-one',
        'title-two',
        'title-three',
        'title-for',
        'text_first',
        'text_second',
        'text_third',
        'subtitle',
        'label',
        'question',
        'answer',
        'url',
        'sub_title',
        'text-item',
        'phone',
        'email',
        'content',
    ];

    const MAX_FILE_SIZE = 1024 * 3;
    const MEDDIUM_FILE_SIZE = 1024 * 6;

    public static function getBlocks(): array
    {
        return [
            Title::make(),
            TitleWithTwoInputsList::make(),
            ImageWithTitleAndDescription::make(),
            SubTitle::make(),
            Description::make(),
            DescriptionEditor::make(),
            Button::make(),
            ColorBackground::make(),
            Faq::make(),
            FaqWithInputs::make(),
            KeyValue::make(),
            Services::make(),
            ImgList::make(),
            Image::make(),
            File::make(),
            TitleImageIconUrlItem::make(),
            ThreeCartsList::make(),
            FileAndTwoTitleList::make(),
            CardWithCounter::make(),
            CardList::make(),
            TextList::make(),
            TitleEditorTextList::make(),
            IconTitleDescriptionList::make(),
            ColorPickerColor::make(),
            ContainerColorPicker::make(),
            TitleDescriptionTitleDescriptionList::make(),
            IconTitleSubTitleImageList::make(),
        ];
    }

    public function getBlockAttribute()
    {
        $data = $this->content;
        return $this->getBlock($data);
    }

    public function getBlock(array $data = []): array
    {
        $res = [];
        foreach ($data as $value) {
            if (!isset($value['type'])) {
                dd($data);
            }
            $res[] = [
                'type' => $value['type'],
                'data' => $this->getData($value['data']),
            ];
        }
        return $res;
    }


    public function getData(array $data = []): array
    {
        $res = [];
        foreach ($data as $key => $value) {
            if (is_array($value) && !in_array($key, self::IMAGE_FIELDS) && !in_array($key, self::TRANSLATABLE_FIELDS)) {
                $res[] = [
                    'key' => $key,
                    'items' => $this->getBlock($value),
                    'type' => 'items',
                ];
            } else {
                //                if(is_array($value) && in_array($key, self::IMAGE_FIELDS)){
                //                    dd($data,$key,$value);
                //                }

                if (in_array($key, self::TRANSLATABLE_FIELDS)) {
                    if (is_array($value)) {
                        $locale = app()->getLocale();
                        if (isset($value[$locale])) {
                            $value = $value[$locale];
                        } else {
                            $value = $value[config('app.fallback_locale')] ?? null;
                        }
                    }
                }

                if (in_array($key, self::IMAGE_FIELDS)) {
                    if (is_array($value)) {
                        $new_value = null;
                        foreach ($value as $image) {
                            $new_value = $image;
                        }
                        $value = $new_value;
                    }
                    $value = $value ? asset('storage/' . $value) : null;
                }

                $res[] = [
                    'key' => $key,
                    'value' => $value,
                    'type' => 'field',
                ];
            }
        }
        return $res;
    }
}
