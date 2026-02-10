<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait FindByKey
{
    /**
     * Cari record dari slug / uuid / id
     */
    public static function findByKey($value)
    {
        $instance = new static;
        $query = $instance->newQuery();

        // Kalau slug valid
        if (method_exists($instance, 'hasColumn')
            && method_exists($instance, 'isValidSlug')
            && $instance->hasColumn('slug')
            && $instance->isValidSlug($value)) {
            return $query->where('slug', $value)->first();
        }
        // Kalau UUID valid
        if (method_exists($instance, 'isValidUuid') && $instance->isValidUuid($value)) {
            return $query->where('uuid', $value)->first();
        }

        // Default: ID
        return $query->where('id', $value)->first();
    }

    /**
     * Cek apakah kolom ada di tabel
     */
    protected function hasColumn($column)
    {
        return \Schema::hasColumn($this->getTable(), $column);
    }

    /**
     * Validasi UUID
     */
    protected function isValidUuid($value)
    {
        return Str::isUuid($value);
    }

    /**
     * Validasi slug (contoh sederhana, bisa override di model)
     */
    protected function isValidSlug($value)
    {
        return is_string($value) && preg_match('/^[a-z0-9-]+$/', $value);
    }
}
