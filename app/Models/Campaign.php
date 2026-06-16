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

    public function getImageUrlAttribute(): string
    {
        $showUploaded = $this->gambar && 
                        file_exists(public_path('storage/' . $this->gambar));

        if ($showUploaded) {
            return asset('storage/' . $this->gambar);
        }

        $judulLower = strtolower($this->judul ?? '');
        $kategoriLower = strtolower($this->kategori ?? '');

        if (str_contains($judulLower, 'jembatan')) {
            $imgFallback = 'images/campaign_jembatan.png';
        } elseif (str_contains($judulLower, 'sembako') || str_contains($judulLower, 'lansia')) {
            $imgFallback = 'images/campaign_sembako.png';
        } elseif (str_contains($judulLower, 'mangrove') || str_contains($judulLower, 'tanam')) {
            $imgFallback = 'images/campaign_mangrove.png';
        } elseif (str_contains($judulLower, 'air') || str_contains($judulLower, 'sumur') || str_contains($judulLower, 'kering') || str_contains($judulLower, 'kekeringan')) {
            $imgFallback = 'images/campaign_air.png';
        } elseif (str_contains($judulLower, 'ambulans')) {
            $imgFallback = 'images/campaign_ambulans.png';
        } elseif (str_contains($kategoriLower, 'bencana') || str_contains($kategoriLower, 'alam') || str_contains($kategoriLower, 'banjir')) {
            $imgFallback = 'images/campaign_bencana.png';
        } elseif (str_contains($kategoriLower, 'didik') || str_contains($kategoriLower, 'sekolah') || str_contains($kategoriLower, 'pendidikan') || str_contains($judulLower, 'beasiswa') || str_contains($judulLower, 'yatim')) {
            $imgFallback = 'images/campaign_pendidikan.png';
        } else {
            $imgFallback = 'images/campaign_kesehatan.png';
        }

        return asset($imgFallback);
    }
}
