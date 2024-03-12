<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'erp_code',
        'type_id',
        'plant',
        'active',
        'history',
        'note'
      ];
      
      public function type(): BelongsTo
      {
        return $this->belongsTo(DeviceType::class, 'type_id');
      }
}
