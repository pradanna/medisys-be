<?php

namespace App\Traits;

trait Uuid
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = \Ramsey\Uuid\Uuid::uuid4()->toString();
            }
        });

        // pdo_odbc on Mac returns uniqueidentifier as 16 raw bytes (mixed-endian).
        // pdo_sqlsrv on Windows returns it as a formatted UUID string.
        static::retrieved(function ($model) {
            $key = $model->getKeyName();
            $value = $model->getAttributeValue($key);
            if (is_string($value) && strlen($value) === 16) {
                $model->setAttribute($key, sprintf('%s-%s-%s-%s-%s',
                    bin2hex(strrev(substr($value, 0, 4))),
                    bin2hex(strrev(substr($value, 4, 2))),
                    bin2hex(strrev(substr($value, 6, 2))),
                    bin2hex(substr($value, 8, 2)),
                    bin2hex(substr($value, 10, 6))
                ));
            }
        });
    }
}
