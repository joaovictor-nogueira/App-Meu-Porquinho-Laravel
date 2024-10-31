<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    protected $fillable = ['carteira_id','categoria_id', 'tipo', 'valor', 'descricao'];


    public function carteira(){
        return $this->belongsTo('App\Models\Carteira');
    }

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }
}
