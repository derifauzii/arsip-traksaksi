<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nomor_cs',
        'nama_cs',
        'alamat',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getTransactionCountAttribute(): int
    {
        return $this->transactions()->count();
    }

    public function getTotalPdfFilesAttribute(): int
    {
        return $this->transactions()->get()->sum(function ($transaction) {
            return count($transaction->pdf_files ?? []);
        });
    }
}
