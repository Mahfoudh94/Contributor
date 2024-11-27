<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'profile_picture_url',
        'resume_url',
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
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile-picture')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(300)
                    ->height(300)
                    ->fit(Fit::Contain);
            });
        $this->addMediaCollection('resume')
            ->singleFile()
            ->acceptsMimeTypes(['image/*', 'application/pdf']);
    }

    protected function profilePictureUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => $this->getFirstMediaUrl('profile-picture', 'thumb'),
        );
    }

    protected function resumeUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => $this->getFirstMediaUrl('resume'),
        );
    }

    public function linkedSocialAccounts(): HasOne
    {
        return $this->hasOne(LinkedSocialAccount::class);
    }
    public function githubAccount(): HasOne
    {
        return $this->hasOne(UserGithubAccount::class, 'user_id');
    }
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badge');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }
}
