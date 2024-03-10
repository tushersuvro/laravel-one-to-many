<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'potential_diagnosis',
        'medicine',
        'test'
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
}
