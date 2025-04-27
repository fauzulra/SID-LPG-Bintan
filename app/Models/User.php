<?php

    namespace App\Models;

    use Spatie\Permission\Traits\HasRoles;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable
    {
        use HasFactory, Notifiable, HasRoles;
        

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
       
    ];

    protected $guard_name = 'web'; 

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
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Hubungan ke tabel distributor.
     */
    public function distributor() 
    {
        return $this->hasOne(Distributor::class, 'id_user');
    }

    /**
     * Otomatis assign role saat user dibuat, jika ada nilai 'role'.
     */
    protected static function booted()
    {
        static::created(function ($user) {
            if (isset($user->attributes['role']) && !$user->hasRole($user->attributes['role'])) {
                $user->assignRole($user->attributes['role']);
            }
        });
    }

    
}
