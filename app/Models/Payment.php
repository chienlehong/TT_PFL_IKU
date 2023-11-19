<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table ='payments';

    protected $fillable = [
        'payment_status',
        'payment_type',
        'amount'
    ];
    public function order(){
        return $this->hasMany(Order::class);
    }
}
