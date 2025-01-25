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
        'ket_lokasi',
        'tahun_inactive',
        'tahun_musnah',
        'status'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classificationCode(): BelongsTo
    {
        return $this->belongsTo(ClassificationCode::class, 'classification_code_id');
    }
}
