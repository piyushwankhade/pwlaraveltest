<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'bank_name',
        'bank_address',
        'balance'
    ];

    

    public function fromTransactions()
    {
        return $this->hasMany(Transaction::class,'from_account_id','id');
    }

    public function toTransactions()
    {
        return $this->hasMany(Transaction::class,'to_account_id','id');
    }
}
