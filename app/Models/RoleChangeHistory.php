<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleChangeHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'previous_role_id',
        'new_role_id',
        'changed_by',
        'changed_at',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function previousRole()
    {
        return $this->belongsTo(Role::class, 'previous_role_id');
    }

    public function newRole()
    {
        return $this->belongsTo(Role::class, 'new_role_id');
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
