<?php

namespace App\Models;

use App\Enums\DocumentPackageStatus;
use Database\Factories\DocumentPackageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'template_id', 'status', 'data', 'file_path'])]
class DocumentPackage extends Model
{
    /** @use HasFactory<DocumentPackageFactory> */
    use HasFactory;

    protected $casts = [
        'status' => DocumentPackageStatus::class,
        'data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(DocumentTemplate::class, 'template_id');
    }
}
