<?php

namespace Modules\Pages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Sidebar extends Model
{
    use HasFactory;
    use NodeTrait;
    use HasTranslations;
    use HasSlug;

    public array $translatable = [
        'name',
    ];
    protected $fillable = [
        'name',
        'order',
        'parent_id',
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->usingLanguage('uk');
    }
    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, 'sidebar_to_page', 'sidebar_id','page_id')->orderBy('order');
    }
    public function sidebars(): BelongsToMany
    {
        return $this->belongsToMany(Sidebar::class, 'sidebar_to_page')->withPivot('sort_order')
            ->using(SidebarPage::class)->orderByPivot('sort_order');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Sidebar::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Sidebar::class, 'parent_id')->orderBy('order');
    }
}
