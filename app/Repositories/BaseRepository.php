<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryContract;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Closure;
use Throwable;

/**
 * Class BaseRepository
 * @package App\Repositories
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
abstract class BaseRepository implements BaseRepositoryContract
{
    /**
     * @var Model|Builder $model
     */
    protected $model;

    /**
     * @var Builder
     */
    protected Builder $query;

    protected array $searchParams;


    public function __construct(Model $model = null)
    {
        if ($model) {
            $this->model = $model;
        }
    }

    /**
     * @param $entityId
     * @return Model|null
     */
    public function find($entityId): ?Model
    {
        return $this->model->find($entityId);
    }

    /**
     * @param string $uuid
     * @return Model|null
     */
    public function findByUuid(string $uuid): ?Model
    {
        return $this->model->where(['uuid' => $uuid])->first();
    }

    /**
     * @param int $entityId
     * @param array $with
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findWith(int $entityId, array $with): ?Model
    {
        return $this->model->with($with)->find($entityId);
    }

    /**
     * @param $uuid
     * @param array $with
     * @return Builder|Model|object|null
     */
    public function findByUuidWith($uuid, array $with): ?Model
    {
        return $this->model->with($with)->where('uuid', $uuid)->first();
    }

    /**
     * @param array $entityIds
     * @return Collection
     */
    public function findMany(array $entityIds): Collection
    {
        return $this->model->findMany($entityIds);
    }

    /**
     * @param array $entityIds
     * @param array $with
     * @return Collection|null
     */
    public function findManyWith(array $entityIds, array $with): ?Collection
    {
        return $this->model->with($with)->findMany($entityIds);
    }

    /**
     * @param int $entityId
     * @return Model|null
     */
    public function findIncludingTrashed(int $entityId): ?Model
    {
        return $this->model->withTrashed()->find($entityId);
    }

    /**
     * @param int $entityId
     * @param array $with
     * @return Model|null
     */
    public function findWithIncludingTrashed(int $entityId, array $with): ?Model
    {
        return $this->model->withTrashed()->with($with)->find($entityId);
    }

    /**
     * @param int $entityId
     * @param array $with
     * @return Model|null
     */
    public function findWithOnlyTrashed(int $entityId, array $with): ?Model
    {
        return $this->model->onlyTrashed()->with($with)->find($entityId);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public function firstOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model->firstOrCreate($attributes, $values);
    }

    /**
     * @return Collection|Model[]|mixed
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $with
     * @return Builder[]|Collection|mixed
     */
    public function allWith(array $with): Collection
    {
        return $this->model->with($with)->get();
    }

    /**
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function paginate(array $params = []): LengthAwarePaginator
    {
        return $this->model->paginate($params);
    }

    /**
     * @param array $data
     * @return Model|null
     */
    public function create(array $data): ?Model
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param int $count
     * @return Collection
     */
    public function createMultiple(array $data, int $count): Collection
    {
        $collection = new Collection();
        for ($i = 1; $i <= $count; $i++) {
            $collection->add($this->create($data));
        }
        return $collection;
    }

    /**
     * @param $attributes
     * @param array $values
     * @return Model|void
     */
    public function updateOrCreate($attributes, $values = []): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * @param Model $model
     * @param array $data
     * @return Model|null
     */
    public function update(Model $model, array $data): ?Model
    {
        $model->fill($data)->save();
        return $model;
    }

    /**
     * @param array $ids
     * @param array $data
     * @return int|mixed
     */
    public function bulkUpdate(array $ids, array $data): int
    {
        return $this->model->newQuery()->whereIn('id', $ids)->update($data);
    }

    /**
     * @param $model
     * @return boolean
     * @throws Exception
     */
    public function destroy(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * @param $model
     * @return mixed
     */
    public function restore(Model $model)
    {
        return $model->restore();
    }

    /**
     * @param $model
     * @return mixed
     */
    public function purge($model)
    {
        return $model->forceDelete();
    }

    /**
     * @param array $attributes
     * @return Model|null
     */
    public function findByAttributes(array $attributes): ?Model
    {
        return $this->model->where($attributes)->first();
    }

    /**
     * @param array $attributes
     * @return Model|null
     */
    public function findByAttributesIncludingTrashed(array $attributes): ?Model
    {
        return $this->model->withTrashed()->where($attributes)->first();
    }

    /**
     * @param array $attributes
     * @return Collection
     */
    public function findManyByAttributes(array $attributes): Collection
    {
        return $this->model->where($attributes)->get();
    }

    /**
     * @return Model|mixed
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param $model
     * @return BaseRepository
     */
    public function setModel($model): BaseRepository
    {
        $this->model = $model;
        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }


    /**
     * @param array $params
     * @return LengthAwarePaginator|Builder[]|Builder|Collection
     */
    public function search(array $params = [])
    {
        if (isset($params['with_server'])) {
            if (!isset($params['with'])) {
                $params['with'] = $params['with_server'];
            }
            $params['with'] = array_merge($params['with_server'], $params['with']);
        }
        if (isset($params["with"])) {
            $this->query->with($params["with"]);
        }

        if ($params['with_pagination'] === 'active') {
            return $this->query->paginate($params["per_page"])->appends($params);
        }

        return $this->query
            ->forPage($params["page"], $params["per_page"])
            ->get();
    }

    protected function quickSearch(array $searchParams, array $searchableParams)
    {
        if (!isset($searchParams['search_fields']) || !isset($searchParams['search'])) {
            return;
        }

        $searchFields = explode(",", $searchParams['search_fields']);
        $search = $searchParams['search'];


        $this->query->where(function (Builder $query) use ($searchFields, $searchParams, $search, $searchableParams) {
            foreach ($searchFields as $field) {
                if (!in_array($field, $searchableParams)) {
                    continue;
                }
                $method = 'searchOr' . Str::studly($field);

                if (method_exists($this, $method)) {
                    call_user_func([$this, $method], $search, $query);
                }
            }
        });
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setSearchParams(array $params): BaseRepositoryContract
    {
        $this->searchParams = $params;
        return $this;
    }

    /**
     * @param Closure $closure
     * @return mixed
     * @throws Throwable
     */
    public function transaction(Closure $closure)
    {
        return DB::transaction($closure);
    }
}
