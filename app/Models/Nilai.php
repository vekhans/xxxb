<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilais';
	protected $primaryKey = 'id';
    protected $fillable = [
        'kriteria',
        'nilai1',
        'nilai2',
        'bobot',
    ];

//membuat relasi dengan tabel user

    public function kriterias()
    {
        return $this->belongsTo('App\Models\Kriteria','kriteria');
    }

}
