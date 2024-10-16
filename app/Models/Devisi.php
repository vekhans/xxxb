<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devisi extends Model
{
    use HasFactory;
    protected $table = 'devisis'; 
	protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'periode', 
        'status',
    ];
    
    public function devperiode()
    {
        return $this->belongsTo('App\Models\Periode','periode');
    }
    public function deva()
    {
        return $this->hasMany('App\Models\Alternatif','devisi');
    }
    public function devanb()
    {
        return $this->hasMany('App\Models\Alternatifnb','devisi');
    }
    public function devk()
    {
        return $this->hasMany('App\Models\Kriteria','devisi');

    }
    public function devknb()
    {
        return $this->hasMany('App\Models\Kriterianb','devisis');
    }
}
