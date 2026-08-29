<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalSheet extends Model
{
    use HasFactory;

    protected $table = 'approval_sheets';

    protected $fillable = [
        'title',
        'line_name',
        'machine_type',
        'ai_result',
        'status',
        'created_by',
    ];

    /**
     * Konversi atribut ai_result menjadi Array otomatis.
     */
    protected $casts = [
        'ai_result' => 'array',
    ];

    /**
     * Relasi ke User yang membuat sheet (Opsional)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}