<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\ReadOnlyException;

trait ReadOnlyModel
{
    /**
     * @throws ReadOnlyException
     */
    public static function create(array $attributes = [])
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public static function forceCreate(array $attributes)
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function save(array $options = [])
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function update(array $attributes = [], array $options = [])
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public static function firstOrCreate(array $attributes, array $values = [])
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public static function firstOrNew(array $attributes, array $values = [])
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public static function updateOrCreate(array $attributes, array $values = [])
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function delete()
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public static function destroy($ids)
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function restore()
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function forceDelete()
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function performDeleteOnModel()
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function push()
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function finishSave(array $options)
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function performUpdate(Builder $query, array $options = [])
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function touch()
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function insert()
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }

    /**
     * @throws ReadOnlyException
     */
    public function truncate()
    {
        throw new ReadOnlyException(__FUNCTION__, get_called_class());
    }
}
