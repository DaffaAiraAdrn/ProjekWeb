<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'filename',
        'original_name',
        'file_path',
        'file_type',
        'file_size',
        'mime_type',
        'alt_text',
    ];
}
