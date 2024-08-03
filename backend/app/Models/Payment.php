<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'payload',
      'amount',
      'currency_iso_code',
      'status'
    ];

    public function scopeSearch(Builder $query, $data): Builder
    {
        if (!$data) {
            return $query;
        }
        if ($details = $data['details']) {
            $query->where('payload', 'LIKE', '%' . $details . '%');
        }
        if ($id = $data['id']) {
            $query->where('id', $id);
        }

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
