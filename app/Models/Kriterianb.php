<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriterianb extends Model
{
    use HasFactory;
    protected $table = 'kriterianbs'; 
	protected $primaryKey = 'id';
    protected $fillable = [
        'periode',
        'devisi',
        'id1',
        'id2',
        'nilai',
    ];

//membuat relasi dengan tabel user    
	public function periodenbk()
    {
        return $this->belongsTo('App\Models\Periode','periode');
    }
    public function Kriterias1()
    {
        return $this->belongsTo('App\Models\Kriteria','id1');
    }
    public function Kriterias2()
    {
        return $this->belongsTo('App\Models\Kriteria','id2');
    } 
}
