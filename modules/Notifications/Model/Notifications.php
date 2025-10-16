<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Notifications extends Model implements HasMedia
{
    use InteractWithMedia;
    use HasTranslations;


    protected $table = "notifications";

    protected $fillable = [
        'title',
        'body',
        'read_at',
        'active',
    ];

    public array $translatable = [
        'title',
        'body',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')->nonQueued();
    }
}
