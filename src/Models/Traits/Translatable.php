<?php

namespace Clumsy\CMS\Models\Traits;

use Illuminate\Support\Str;
use Clumsy\CMS\Facades\International;

trait Translatable
{
    protected static $translatableMutators = [];

    protected static function translatables()
    {
        if (isset(static::$translatable)) {
            return (array)static::$translatable;
        }

        return [];
    }

    protected static function bootTranslatable()
    {
        foreach (static::translatables() as $translatable) {
            static::$mutatorCache[get_called_class()][] = $translatable;
            static::$translatableMutators['get'.studly_case($translatable).'Attribute'] = $translatable;
        }
    }

    public static function localizeColumn($column, $locale = null)
    {
        if (!$locale) {
            $locale = International::getCurrentLocale();
        }

        return $column.'_'.$locale;
    }

    public function scopeGetFromLocalizedSlug($query, $column, $slug)
    {
        $column = self::localizeColumn($column);

        $items = $query->get();
        return $items->filter(function ($item) use ($column, $slug) {

                return Str::slug($item->$column) === $slug;
        });
    }

    public function translatable($column, $locale = null)
    {
        $column = $this->localizeColumn($column, $locale);

        return $this->$column;
    }

    public function localizeOrderBy(\Illuminate\Database\Eloquent\Builder $query, $column, $direction = 'asc')
    {
        $column = $this->localizeColumn($column);

        return $query->orderBy($column, $direction);
    }

    public function scopeOrderLocalized($query, $column, $direction = 'asc')
    {
        return $this->localizeOrderBy($query, $column, $direction);
    }

    public function scopePluckWithId($query, $column)
    {
        $column = $this->localizeColumn($column);

        return $query->pluck($column, 'id');
    }

    public function scopeListsWithId($query, $column)
    {
        return $this->scopePluckWithId($query, $column);
    }

    public function hasTranslatableGetMutator($key)
    {
        return in_array($key, static::translatables());
    }

    public function hasGetMutator($key)
    {
        return $this->hasTranslatableGetMutator($key) || method_exists($this, 'get'.studly_case($key).'Attribute');
    }

    public function __call($method, $parameters)
    {
        if (array_key_exists($method, static::$translatableMutators)) {
            return $this->translatable(static::$translatableMutators[$method]);
        }

        return parent::__call($method, $parameters);
    }
}
