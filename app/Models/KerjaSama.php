<?php

namespace App\Models;

use App\Models\ProdukKerjaSama;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KerjaSama extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['masa_kerja_sama'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getMasaKerjaSamaAttribute()
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai);
    }

    public function produkKerjaSama()
    {
        return $this->hasMany(ProdukKerjaSama::class, 'kerja_samas_id');
    }
}
