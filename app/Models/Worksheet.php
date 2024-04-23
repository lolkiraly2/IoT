<?php
//Model osztály és a kiegészítő felsorolás (enum) osztály
namespace App\Models;

use App\Enums\WorksheetPriority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Worksheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'priority',
        'description',
        'due_date',
        'finish_date',
        'device_id',
        'creator_id',
        'repairer_id',
        'attachments',
        'comment',
    ];

    protected $casts = [
        'priority' => WorksheetPriority::class,
        'attachments' => 'array',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id'); // aki létrehozta a munkalapot
    }

    public function repairer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'repairer_id'); // aki karbantartó!
    }
}
