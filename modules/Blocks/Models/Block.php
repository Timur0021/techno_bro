<?php

namespace Modules\Blocks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Blocks\Casts\BlockCast;
use Modules\Blocks\Traits\HasBlock;
use Modules\Pages\Models\Page;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Block extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasBlock;
//    use HasTranslations;

    protected $fillable = [
        'name',
        'template_block_id',
        'gallery_id',
        'block_type_id',
        'status',
        'content',
        'type',
    ];
    protected $casts = [
        'content' => BlockCast::class,
    ];

    protected static function booted(): void
    {
        static::saved(function (self $block) {
            if ($block->hasMedia('image')) {
                return;
            }

            $template = $block->template;

            if (!$template || !$template->hasMedia('image')) {
                return;
            }

            $media = $template->getFirstMedia('image');

            if (!$media) {
                return;
            }

            $block->addMedia($media->getPath())
                ->preservingOriginal()
                ->toMediaCollection('image');
        });
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(\Modules\Blocks\Models\TemplateBlock::class, 'template_block_id');
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')->nonQueued();
    }
    public function getImageAttribute(): array|null|string
    {
        return $this->getMedia('image')->map(function ($mediaObject) {
            return $mediaObject->getUrl('webp');
        })->toArray()[0] ?? null;
    }

    public function getAdditionalQuery()
    {
        if ($this->attributes['with_additional_query']) {
            $class = $this->attributes['model'];
            if ($class) {
                $count = $this->attributes['count'] ?? 5;
                $query = $class::query();
                if (!$this->attributes['get_all']) {
                    $query->take($count);
                }
                return [
                    'type' => $class,
                    'data' => $query
                ];
            }
        }
        return null;
    }

    public function getDirectionAttribute()
    {
        $data = $this->getAdditionalQuery();
        return isset($data['type']) && $data['type'] == Page::class ? $data['data']->where('page_id', $this->getOriginal('pivot_page_id'))->orderBy('order')->get() : null;
    }

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, 'page_block');
    }
}
