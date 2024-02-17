<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['subtotal', 'priority', 'deliver'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
