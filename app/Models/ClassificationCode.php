<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassificationCode extends Model
{
    protected $table = 'classification_codes';

    protected $fillable = [
        'code',
        'title',
        'active',
        'ket_active',
        'inactive',
        'ket_inactive',
        'keterangan',
        'security',
        'hak_akses',
    ];

    public function classification(): HasMany
    {
        return $this->hasMany(Classification::class, 'classification_code_id');
    }
}
