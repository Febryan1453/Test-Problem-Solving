<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataMesin extends Model
{
    protected $fillable = [
        'kategori_id', 'klasifikasi_id', 'nomor_urut', 'tahun'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Pisahkan nomor urut dari kode kategori, klasifikasi, dan tahun
            $parts = explode('-', $model->nomor_urut);

            // Ambil nomor urut dari bagian terakhir
            $nomorUrut = end($parts);

            // Logika untuk mengatur nomor urut sebelum data disimpan
            $model->nomor_urut = $model->kategori->kode . '-' . $model->klasifikasi->kode . '-' . sprintf('%03d', $nomorUrut) . '-' . $model->tahun;
        });
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function klasifikasi()
    {
        return $this->belongsTo(Klasifikasi::class, 'klasifikasi_id');
    }
}

