<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $table      = 'periodes';
	protected $primaryKey = 'id';
    protected $fillable   = [
        'nama','tahun','keterangan','status'         
    ];
    //membuat relasi dengan tabel user    
	public function periodek()
    {
        return $this->hasMany('App\Models\Kriteria','periode');
    }
    public function periodenbk()
    {
        return $this->hasMany('App\Models\Kriterianb','periode');
    }
    public function periodea()
    {
        return $this->hasMany('App\Models\Alternatif','periode');
    }
    public function periodenba()
    {
        return $this->hasMany('App\Models\Alternatifnb','periode');
    }
}
