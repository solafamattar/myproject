<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
    ];

    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class, 'activity_volunteer');
    }
}

