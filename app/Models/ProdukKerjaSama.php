<?php

namespace App\Models;

use App\Models\FiturKerjaSama;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukKerjaSama extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $casts = [
    //     'fitur_id' => 'array',
    // ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function kerjaSama()
    {
        return $this->belongsTo(KerjaSama::class, 'kerja_samas_id');
    }

    public function fiturs()
    {
        return $this->belongsToMany(Fitur::class, 'fitur_kerja_samas', 'produk_kerja_sama_id', 'fitur_id');
    }

    public function fiturKerjaSama()
    {
        return $this->hasMany(FiturKerjaSama::class, 'produk_kerja_sama_id');
    }
}
