<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'ranks'; 
	protected $primaryKey = 'id';
    protected $fillable = [
        'periode',
        'devisi',
        'alternatif', 
        'total'
    ]; 
    public function perioder()
    {
        return $this->belongsTo('App\Models\Periode','periode');
    }
    public function altr()
    {
        return $this->belongsTo('App\Models\Alternatif','alternatif');
    } 
}
