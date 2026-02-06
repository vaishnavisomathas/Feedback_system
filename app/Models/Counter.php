<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'district',
        'division_name',
        'counter_name',
    ];
    
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
