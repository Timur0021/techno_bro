<?php

namespace Modules\Team\Models;

use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasApiTokens;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'password',
        'email_verified_at',
        'remember_token',
        'subscribe_start',
        'subscribe_end',
        'tariff_id',
        'parents_data',
        'remember_me',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'parents_data' => 'array',
        ];
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id');
    }

    public function course(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_users', 'user_id', 'course_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function history(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_views', 'lesson_id', 'user_id')->withPivot('viewed_at');
    }

    public function emailNotifications(): BelongsToMany
    {
        return $this->belongsToMany(EmailNotification::class, 'email_notification_user', 'user_id', 'email_notification_id');
    }

    public function pushNotifications(): BelongsToMany
    {
        return $this->belongsToMany(PushNotification::class, 'push_notification_user', 'user_id', 'push_notification_id');
    }

    public function getImageAttribute()
    {
        return $this->getMedia('image')->map(function ($mediaObject) {
            return $mediaObject->getUrl();
        })->toArray()[0] ?? null;
    }

    public function getCertificatesAttribute(): array|null|string
    {
        return $this->getMedia('certificates')->map(function ($mediaObject) {
            return $mediaObject->getUrl();
        })->toArray() ?? [];
    }

    public function getBackgroundCertificateAttribute()
    {
        return $this->getMedia('background_certificate')->map(function ($mediaObject) {
            return $mediaObject->getUrl();
        })->toArray()[0] ?? null;
    }

    public function getNotificationsListAttribute()
    {
        $notificationsQuery = $this->notifications();
        $notifications = $notificationsQuery->get();
        $countUnreadNotifications = $notifications->whereNull('read_at')->count();
        return [
            'notifications' => $notifications,
            'countUnreadNotifications' => $countUnreadNotifications,
        ];
    }

    public function getRoleAttribute(): ?string
    {
        return $this->roles()->first()?->name;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $avatarColumn = config('filament-edit-profile.avatar_column', 'avatar_url');
        return $this->$avatarColumn ? Storage::url($this->$avatarColumn) : null;
    }
}
