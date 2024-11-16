<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mkriteria extends Model
{
    use HasFactory;
    protected $table = 'mkriterias';
	protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nama',
        'devisi',
        'periode',
        'satuan',
        'atribut',
    ];
    public function kriteriask()
    {
        return $this->hasMany('App\Models\Kriteria','mkriteria');
    }
}