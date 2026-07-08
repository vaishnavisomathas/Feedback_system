<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualComplaint extends Model
{
    use HasFactory;

    protected $casts = [
        'received_at' => 'date',
    ];

    protected $fillable = [
        'source',
        'source_id',
        'complainant_name',
        'phone',
        'complaint_email',
        'vehicle_number',
        'complain_type_id',
        'complaint',
        'action_note',
        'status',
        'ao_remarks',
        'commissioner_remarks',
        'received_at',
        'entered_by',
            'action_note',

    ];

    public function complainType()
    {
        return $this->belongsTo(ComplainType::class, 'complain_type_id');
    }

    public function enteredByUser()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function sourceSetting()
    {
        return $this->belongsTo(ManualComplaintSource::class, 'source_id');
    }
}
