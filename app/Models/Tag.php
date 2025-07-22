<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // Relationships
    public function files()
    {
        return $this->belongsToMany(FileModel::class, 'file_tags', 'tag_id', 'file_id');
    }

    // Mutator untuk name - akan membuat slug otomatis
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
        // Only update slug if it's a new record or name is actually changing
        if (!$this->exists || $this->getOriginal('name') !== trim($value)) {
            $this->attributes['slug'] = Str::slug(trim($value));
        }
    }

    // Accessor untuk mendapatkan route key
    public function getRouteKeyName()
    {
        return 'id'; // Menggunakan ID untuk routing
    }

    // Scopes
    public function scopePopular($query)
    {
        return $query->withCount('files')->orderBy('files_count', 'desc');
    }
    
    public function scopeWithFileCount($query)
    {
        return $query->withCount('files');
    }
}
