<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LaravelPermissionToVueJS;

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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the projects for the project manager
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function managed_projects(): HasMany
    {
        return $this->hasMany(Project::class, 'project_manager_id');
    }

    /**
     * Get all of the tasks for the developer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assigned_tasks(): HasMany
    {
        return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    }
}
