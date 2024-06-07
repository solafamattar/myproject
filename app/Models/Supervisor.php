<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Supervisor extends Model
{
    use HasFactory, Notifiable;

    protected $table = "supervisors";
    protected $primaryKey = "id";
    protected $fillable = [
        'user_id',
        // يمكن إضافة حقول إضافية إذا لزم الأمر
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }

    public function group()
    {
        return $this->hasOne(Group::class);
    }
}
