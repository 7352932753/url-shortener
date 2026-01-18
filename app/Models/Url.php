<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Url extends Model
{
    protected $fillable = ['short_code', 'original_url', 'user_id', 'company_id', 'clicks'];

    protected static function boot() {
        parent::boot();
        static::creating(function ($url) {
            if (empty($url->short_code)) {
                do {
                    $url->short_code = Str::random(8);
                } while (static::where('short_code', $url->short_code)->exists());
            }
        });
    }

    public function user() { return $this->belongsTo(User::class); }
    public function company() { return $this->belongsTo(Company::class); }

    public function getShortUrlAttribute(): string {
        return url($this->short_code);
    }
}
