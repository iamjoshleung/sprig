<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'basic';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['is_admin'];

    /**
     * Check if the user is admin
     * 
     * @return 
     */
    public function isAdmin() {
        return $this->type === self::ADMIN_TYPE;
    }

    /**
     * 
     * 
     * @return 
     */
    public function getIsAdminAttribute() {
        return $this->isAdmin();
    }
}
