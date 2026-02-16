<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
       protected $table = 'feedbacks'; 
  protected $fillable = [
        'counter_id',
        'rating',
        'service_quality',
        'has_complaint',
        'phone',
        'vehicle_number',
        'note',
        
         'status',
    ];
    
    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }
      public function user()
    {
        return $this->belongsTo(User::class);
    }
}
