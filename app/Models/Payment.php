<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  // Specify the table name if it differs from the plural of the model name
  protected $table = 'payments';

  // Define which fields can be mass-assigned
  protected $fillable = [
      'price',

  ];

  // Specify casts for automatic data conversion
  protected $casts = [
      'price' => 'float',

  ];
}
