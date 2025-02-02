<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    // Specify the table name if it differs from the plural of the model name
    protected $table = 'seats';

    // Define which fields can be mass-assigned
    protected $fillable = [
        'facility_id', // Foreign key to facilities
        'seat_number', // Unique identifier for the seat
        'price',       // Price for the seat
        'status',      // Enable or disable the seat (e.g., 1 = enabled, 0 = disabled)
    ];

    // Specify casts for automatic data conversion
    protected $casts = [
        'price' => 'float',
        //'status' => 'boolean',
    ];

    // Define the relationship to the Facility model
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
