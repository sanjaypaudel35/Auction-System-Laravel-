<?php

namespace App\Core\Repositories;

use App\Core\Traits\Filterable;
use Illuminate\Support\Facades\DB;

class BaseRepository
{
    use Filterable;

    public $model;
    public ?string $modelName;
    public ?string $modelKey;
    protected ?string $tableName;

    protected int $perPage = 25;
    protected bool $isCached = true;
    protected int $cacheTTl = 60; // 60 min

    /**
     * Initialize class properties
     *
     * @return void
     */
    public function __construct()
    {
        $this->modelName = $this->modelName ?? class_basename($this->model);
        $this->tableName = $this->model->getTable();
        $this->modelKey = $this->modelKey ?? $this->tableName;
    }

    /**
     * Get all data from database
     *
     * @param  array $request
     * @param  array $with
     *
     *
     * @return object
     */
    public function fetchAll(array $filterable = [], array $with = []): object
    {
        $this->validateFiltering($filterable);
        $rows = $this->model::query();

        $fetched = $this->getFiltered($rows, $filterable, $with);

        return $fetched;
    }

    /**
     * Get object or redirect to 404.
     *
     * @param  mixed $id
     * @param  mixed $with
     *
     * @return object
     */
    public function fetch(int|string $id, array $with = []): object
    {
        $rows = $this->model::query();
        if ($with != []) {
            $rows = $rows->with($with);
        }

        $fetched = $rows->findOrFail($id);

        return $fetched;
    }

   /**
    * Fetch by specific column
    *
    * @param string $column
    * @param integer|string $value
    * @param array $with
    * @return object
    */
    public function fetchBy(string $column, int|string $value, array $with = []): object
    {
        $rows = $this->model::query();
        if ($with != []) {
            $rows = $rows->with($with);
        }

        $fetched = $rows->where($column, $value)->firstOrFail();

        return $fetched;
    }

    /**
     * query multiple "and where" queries and return eloquent object.
     *
     * @param  array $conditions
     * @param  array $with
     *
     * @return object
     */
    protected function queryFetch(array $conditions, array $with = []): object
    {
        $rows = $this->model::query()->where($conditions);

        if ($with != []) {
            $rows = $rows->with($with);
        }

        return $rows;
    }

    public function queryBuilder(Callable $callback): object
    {
        $rows = $this->model::query();

        return $callback($rows);
    }

    /**
     * Update or Create
     *
     * @param  array $match
     * @param  array $data
     *
     * @return object
     */
    public function updateOrStore(array $match, array $data): object
    {
        $updated = $this->model->updateOrCreate($match, $data);

        return $updated;
    }

    /**
     * store
     *
     * @param  array $data
     *
     * @return object
     */
    public function store(array $data): object
    {
        $created = $this->model->create($data)->fresh();

        return $created;
    }

    /**
     * Query database with id and update.
     *
     * @param  array $data
     * @param  string|int $id
     *
     * @return object
     */
    public function update(array $data, string|int $id): object
    {
        $updated = $this->model->whereId($id)->firstOrFail();
        $updated->update($data);

        return $updated;
    }

    /**
     * Bulk insert data.
     *
     * @param  array $data
     *
     * @return bool
     */
    public function insert(array $data): bool
    {
        $insert = DB::table($this->tableName)->insert($data);

        return $insert;
    }

    /**
     * Query database with id and delete.
     *
     * @param  int|string $id
     *
     * @return void
     */
    public function delete(int|string $id): void
    {
        $this->model::whereId($id)->delete();
    }

    /**
     * Query database with ids and delete. Returns count for deleted ids
     *
     * @param  int|string $ids
     *
     * @return int
     */
    public function bulkDelete(array $ids): int
    {
        $deleteCount = $this->model::whereIn("id", $ids)->delete();

        return $deleteCount;
    }

    /**
     * Sync relations
     *
     * It dose not requires any event
     *
     * @param object $model
     * @param string $relation
     * @param mixed $attributes
     * @param boolean $detaching
     *
     * @return object
     */
    public function sync(
        object $model,
        string $relation,
        mixed $attributes,
        bool $detaching = true
    ): object {
        $model->{$relation}()->sync($attributes, $detaching);

        return $model;
    }

    /**
     * Get object
     *
     * @param  mixed $id
     * @param  mixed $with
     *
     * @return object
     */
    public function get(mixed $id, array $with = [], array $tags = []): mixed
    {
        $rows = $this->model::query();
        if ($with != []) {
            $rows = $rows->with($with);
        }
        $fetched =  $rows->find($id);

        return $fetched;
    }
}
