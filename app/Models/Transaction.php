<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'kode_kegiatan',
        'title',
        'tanggal_faktur',
        'pdf_files',
        'notes',
    ];

    protected $casts = [
        'tanggal_faktur' => 'date',
        'pdf_files' => 'array',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getPdfCountAttribute(): int
    {
        return count($this->pdf_files ?? []);
    }
}
