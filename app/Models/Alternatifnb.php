<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatifnb extends Model
{
    use HasFactory;
    protected $table = 'alternatifnbs';
	protected $primaryKey = 'id';
    protected $fillable = [
        'periode',
        'alternatif',
        'kriteria',
        'nilai',
        'bobot',

    ];
    public function periodea()
    {
        return $this->belongsTo('App\Models\Periode','periode');
    }
    public function alternatifnba()
    {
        return $this->belongsTo('App\Models\Alternatif','alternatif');
    }
    public function kriterianba()
    {
        return $this->belongsTo('App\Models\Kriteria','kriteria');
    }
}
