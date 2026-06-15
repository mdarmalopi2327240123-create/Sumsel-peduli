<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'judul',
        'deskripsi',
        'target',
        'terkumpul',
        'gambar',
        'status',
        'kategori',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    protected $casts = [
        'target' => 'decimal:2',
        'terkumpul' => 'decimal:2',
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function updates(): HasMany
    {
        return $this->hasMany(CampaignUpdate::class);
    }

    public function getProgressPercentage(): float
    {
        if ($this->target == 0) {
            return 0;
        }
        return ($this->terkumpul / $this->target) * 100;
    }
}
