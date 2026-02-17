<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplainType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];
    public function feedbacks()
{
    return $this->hasMany(Feedback::class);
}

}
