<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    // Specify the table name if it's not 'facilities' (default based on class name)
    protected $table = 'facilities';

    // Specify which fields are mass assignable (for bulk insert/update)
    protected $fillable = [
        'name', // Add other columns if you extend the table
    ];

    // Specify any fields that should be hidden in JSON responses (if needed)
    protected $hidden = [];

    // Specify any fields that should be automatically cast (e.g., dates, JSON)
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    // Define the relationship between Facility and Booking
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
