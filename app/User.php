<?php

namespace App;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $dates = [
        'email_verified_at',
        'package_ends_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_admin',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'package_id',
        'package_ends_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'email_verified_at' => 'datetime',
        'package_ends_at' => 'datetime',
    ];

    public function package()
    {
        return $this->belongsTo('App\Models\Package')->withDefault();
    }

    public function subscribed()
    {
        if (is_null($this->package_ends_at)) {
            return false;
        }

        // Ensure package_ends_at is a Carbon instance
        if (!$this->package_ends_at instanceof \Carbon\Carbon) {
            $this->package_ends_at = \Carbon\Carbon::parse($this->package_ends_at);
        }

        return $this->package_ends_at->isFuture();
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        // Admins don't need to verify their email
        if ($this->is_admin) {
            return true;
        }

        return !is_null($this->email_verified_at);
    }

    /**
     * Get all virtual cards for the user
     */
    public function virtualCards()
    {
        return $this->hasMany(VirtualCard::class);
    }

    /**
     * Get all portfolios for the user
     */
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    /**
     * Get all blog posts authored by the user
     */
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

}
