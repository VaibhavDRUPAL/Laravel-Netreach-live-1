<?php

namespace App\Models\LanguageModule;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Language extends Model
{
    use HasFactory;

    const language_master = 'language_master';
    const language_id = 'language_id';
    const name = 'name';
    const label_as = 'label_as';
    const language_code = 'language_code';
    const locale = 'locale';
    const created_at = 'created_at';
    const updated_at = 'updated_at';

    // Table Details
    protected $table = self::language_master;
    protected $primaryKey = self::language_id;
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        self::name,
        self::label_as,
        self::language_code,
        self::locale,
        self::created_at,
        self::updated_at
    ];

    // Hidden
    protected $hidden = [
        self::created_at,
        self::updated_at
    ];

    // Label as
    protected function labelAs(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => ucwords(Str::squish($value))
        );
    }

    // Name
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::squish($value)
        );
    }

    // Language code
    protected function languageCode(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower(Str::squish($value))
        );
    }

    // Locale
    protected function locale(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower(Str::squish($value))
        );
    }

    // Set Request Parameters
    protected static function setRequest($self, $request, $recordType)
    {
        $self->name = $request->input(self::name);
        $self->label_as = $request->input(self::label_as);
        $self->language_code = $request->input(self::language_code);
        $self->locale = $request->input(self::locale);

        if ($recordType === UPDATE_RECORD) {
            $self->updated_at = currentDateTime();
        } else {
            $self->created_at = currentDateTime();
        }
        return $self;
    }

    // Add OR Update Record
    public static function addOrUpdate($request, $recordType)
    {
        $data = $recordType === CREATE_RECORD ? new self : self::find($request->input(self::language_id));

        $data = self::setRequest($data, $request, $recordType);

        if ($data) $data->save();

        return $data ? $data : null;
    }

    // Get All Languages
    public static function getAllLanguages()
    {
        $data = self::all();

        return $data ? $data : null;
    }

    // Get Languages By ID
    public static function getLanguageByID($request)
    {
        $data = self::find($request->input(self::language_id));

        return $data ? $data : null;
    }

    // Delete Language
    public static function deleteLanguage($request)
    {
        return self::destroy($request->input(self::language_id));
    }
}