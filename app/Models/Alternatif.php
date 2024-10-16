<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;
    protected $table = 'alternatifs'; 
	protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nama', 
        'periode'
    ];
    public function alternatinba()
    {
        return $this->hasMany('App\Models\Alternatifnb','alternatif');
    }
    public function alrank()
    {
        return $this->hasMany('App\Models\Rank','alternatif');
    }
    public function periodea()
    {
        return $this->belongsTo('App\Models\Periode','periode');
    }
    public function altrank()
    {
        return $this->belongsToMany(Alternatif::class,'ranks','alternatif','devisi');
    }
}
