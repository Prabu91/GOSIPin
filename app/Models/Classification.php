<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classification extends Model
{
    protected $table = 'classification_tables';

    protected $fillable = [
        'user_id',
        'classification_code_id',
        'bagian',
        'nomor_berkas',
        'nomor_item_berkas',
        'uraian_berkas',
        'date',
        'jumlah',
        'satuan',
        'perkembangan',
        'lokasi',
        'box_number',
        'tahun_inactive',
        'tahun_musnah',
        'status',
        'klasifikasi_box',
        'status_box',
        'rak_number'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classificationCode(): BelongsTo
    {
        return $this->belongsTo(ClassificationCode::class, 'classification_code_id');
    }
}
