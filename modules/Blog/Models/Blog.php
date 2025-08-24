<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Blog extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasSlug;
    use HasTranslations;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image_alt',
        'image_title',
        'sort_order',
        'views_count',
        'meta_title',
        'meta_description',
        'active',
        'published_at',
    ];

    public array $translatable = [
        'title',
        'description',
        'short_description',
        'meta_title',
        'meta_description',
        'image_alt',
        'image_title',
    ];

    protected $attributes = [
        'views_count' => 0,
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingLanguage('en')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')->nonQueued();
    }

    public function getImageAttribute(): array|null|string
    {
        return $this->getMedia('image')->map(function ($mediaObject) {
            return $mediaObject->getUrl();
        })->toArray()[0] ?? null;
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_categories_pivot', 'blog_id', 'category_id');
    }
}
