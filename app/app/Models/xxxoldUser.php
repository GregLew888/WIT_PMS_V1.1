<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\UserRelations;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens,HasFactory, Notifiable, HasRoles, InteractsWithMedia, UserRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'recent_searches' => 'array',
    ];

    // Set the password attribute and hash it
    public function setPasswordAttribute($value)
    {
        // Hash the password only if it's not already hashed
        $this->attributes['password'] = Hash::make($value);
    }

    // Accessor to get age from birth_date
    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    // Accessor to format the full address
    public function getFullAddressAttribute()
    {
        $addressParts = array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->post_code,
            $this->country
        ]);

        return implode(', ', $addressParts);
    }

    /**
     * Add a search term to recent searches.
     *
     * @param string $term
     * @return void
     */
    public function addRecentSearch(string $term): void
    {
        // Get the current recent searches or default to an empty array
        $recentSearches = $this->recent_searches ?? [];

        // Remove the term if it already exists to avoid duplicates
        $recentSearches = array_filter($recentSearches, fn($search) => $search !== $term);

        // Add the new term to the beginning of the array
        array_unshift($recentSearches, $term);

        // Ensure all searches are unique, then keep only the latest 5 searches
        $this->recent_searches = array_slice(array_unique($recentSearches), 0, 5);

        // Save the changes
        $this->save();
    }

    
    /**
     * scope the query to active users only
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeActive($query)
    {
        $query->where('status', true);
    }

    /**
 * Add or update the profile image for the user.
 *
 * @param  \Illuminate\Http\UploadedFile|string $file
 * @return void
 */
public function updateProfileImage($file): void
{
    // Remove the existing profile image if it exists
    if ($this->hasMedia('profile_image')) {
        $this->getFirstMedia('profile_image')->delete();
    }

    // Add the new profile image to the 'profile_image' media collection
    $this->addMedia($file)->toMediaCollection('profile_image');
}

/**
 * Get the URL of the profile image.
 *
 * @return string|null
 */
public function getProfileImageUrl(): ?string
{
    // Return the URL of the profile image, or null if it doesn't exist
    return $this->hasMedia('profile_image') 
        ? $this->getFirstMediaUrl('profile_image') 
        : null;
}

}
