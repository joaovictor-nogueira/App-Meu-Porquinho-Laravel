<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carteira extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'saldo'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function transacoes(){
        return $this->hasMany('App\Models\Transacao');
    }
}
