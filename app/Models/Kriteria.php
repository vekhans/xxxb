<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriterias'; 
	protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nama',
        'devisi',
        'periode', 
        'atribut',
    ];
    public function kriterias1()
    {
        return $this->hasMany('App\Models\Kriterianb','id1');
    }
    public function kriterias2()
    {
        return $this->hasMany('App\Models\Kriterianb','id2');
    }
    public function kriterias3()
    {
        return $this->hasMany('App\Models\Alternatifnb','kriteria');
    }
    public function periodek()
    {
        return $this->belongsTo('App\Models\Periode','periode');
    }
    public function devk()
    {
        return $this->belongsTo('App\Models\Devisi','devisi');
    }
}
