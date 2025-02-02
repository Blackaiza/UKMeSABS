<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
       // Specify the table name if it's not 'facilities' (default based on class name)
       protected $table = 'carts';

       // Specify which fields are mass assignable (for bulk insert/update)
       protected $fillable = [
          'user_id',
           'date', // Add other columns if you extend the table
           'time_id',
           'facility_id',
           'seat_id',
           'price',
           'booking_id_succesful'
       ];

       // Specify any fields that should be hidden in JSON responses (if needed)
       protected $hidden = [];

       // Specify any fields that should be automatically cast (e.g., dates, JSON)
       protected $casts = [
        'price' => 'float',
       ];

       public function user() {
        return $this->belongsTo(User::class);
    }

    public function time() {
        return $this->belongsTo(Time::class);
    }

    public function facility() {
        return $this->belongsTo(Facility::class);
    }

    public function seat() {
        return $this->belongsTo(Seat::class);
    }

}
