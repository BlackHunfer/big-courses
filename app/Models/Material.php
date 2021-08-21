<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Material extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'theme_id',
        'user_id',
        'material_type_id',
        'title',
        'upload_file',
        'text',
        'order',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('date_start', 'date_end', 'upload_file', 'result', 'grade')->withTimestamps();
    }
}
