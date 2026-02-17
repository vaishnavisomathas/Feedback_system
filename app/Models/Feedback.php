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
        'service_quality_id',
        'has_complaint',
        'phone',
        'vehicle_number',
        'note',
         'complain_type_id', 
         'status',
           'user_remarks',
            'ao_remarks'
    ];
    
    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }
      public function user()
    {
        return $this->belongsTo(User::class);
    }
  public function complainType()
{
    return $this->belongsTo(ComplainType::class);
}
  public function serviceQuality()
{
    return $this->belongsTo(ServiceQuality::class);
}

}
