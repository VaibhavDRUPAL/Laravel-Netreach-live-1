<?php

namespace App\Casts\Self\Appointment;

use App\Models\SelfModule\Appointments;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ServiceList implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $service = null;

        foreach (json_decode($attributes[Appointments::services]) as $value)
            $service .= SERVICES[intval($value)] . ', ';

        return $service;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        //
    }
}
