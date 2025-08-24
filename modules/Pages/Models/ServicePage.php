<?php

namespace Modules\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Services\Models\Service;
use Spatie\Translatable\HasTranslations;

class ServicePage extends Model
{
    use HasTranslations;

    protected $table = 'services_pages';

    protected $fillable = [
        'title',
        'content_left',
        'content_right',
    ];

    public array $translatable = [
        'title',
        'content_left',
        'content_right',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_service_page', 'service_page_id', 'service_id');
    }
}
