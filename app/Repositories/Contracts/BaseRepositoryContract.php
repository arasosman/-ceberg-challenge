<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Closure;

interface BaseRepositoryContract
{
    /**
     * Idsi verilen elemanı döner.
     * @param int $entityId
     * @return Model|null $model
     * @internal param array|int $id
     */
    public function find(int $entityId): ?Model;

    /**
     * @param string $uuid
     * @return Model|null
     */
    public function findByUuid(string $uuid): ?Model;

    /**
     * @param array $entityIds
     * @return Collection
     */
    public function findMany(array $entityIds): Collection;

    /**
     * @param array $entityIds
     * @param array $with
     * @return Collection|null
     */
    public function findManyWith(array $entityIds, array $with): ?Collection;

    /**
     * Idsi verilen elemanı istenilen ilişkileri ile döner.
     * @param int $entityId
     * @param array $with
     * @return Model|null $model
     * @internal param array|int $id
     */
    public function findWith(int $entityId, array $with): ?Model;

    /**
     * @param string $uuid
     * @param array $with
     * @return Model|null
     */
    public function findByUuidWith(string $uuid, array $with): ?Model;

    /**
     * @param int $entityId
     * @return Model|null
     */
    public function findIncludingTrashed(int $entityId): ?Model;

    /**
     * @param int $entityId
     * @param array $with
     * @return Model|null
     */
    public function findWithIncludingTrashed(int $entityId, array $with): ?Model;

    /**
     * @param int $entityId
     * @param array $with
     * @return Model|null
     */
    public function findWithOnlyTrashed(int $entityId, array $with): ?Model;

    /**
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public function firstOrCreate(array $attributes, array $values = []): Model;

    /**
     * Kaynağın tüm elemanlarını döner
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param array $with
     * @return Collection
     */
    public function allWith(array $with): Collection;

    /**
     * Sayfalanmış koleksiyon döner.
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function paginate(array $params = []): LengthAwarePaginator;

    /**
     * Yeni kayıt oluşturur.
     * @param array $data
     * @return Model
     */
    public function create(array $data): ?Model;

    /**
     * @param array $data
     * @param int $count
     * @return Collection
     */
    public function createMultiple(array $data, int $count): Collection;

    /**
     * Create or update resource
     *
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values = []): Model;

    /**
     * Kaydı günceller.
     * @param Model $model
     * @param array $data
     * @return Model|null
     */
    public function update(Model $model, array $data): ?Model;

    /**
     * @param array $ids
     * @param array $data
     * @return int
     */
    public function bulkUpdate(array $ids, array $data): int;

    /**
     * Kaydı kaldırır.
     * @param $model
     * @return bool
     */
    public function destroy(Model $model): bool;

    /**
     * Kaydı onarır.
     * @param $model
     * @return mixed
     */
    public function restore(Model $model);

    /**
     * @param $model
     * @return mixed
     */
    public function purge(Model $model);

    /**
     * Özellikleri verilen bir kaydı bulur.
     * @param array $attributes
     * @return Model|null
     */
    public function findByAttributes(array $attributes): ?Model;

    /**
     * Özellikleri verilen bir kaydı bulur.
     * @param array $attributes
     * @return Model|null
     */
    public function findByAttributesIncludingTrashed(array $attributes): ?Model;

    /**
     * Özellikleri verilen bir çok kaydı bulur.
     * @param array $attributes
     * @return Collection
     */
    public function findManyByAttributes(array $attributes): Collection;

    /**
     * @return Model
     */
    public function getModel(): Model;

    /**
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model): BaseRepositoryContract;

    /**
     * @param array $params
     * @return LengthAwarePaginator|Builder[]|Builder|Collection
     */
    public function search(array $params = []);

    /**
     * @param array $params
     * @return self
     */
    public function setSearchParams(array $params): BaseRepositoryContract;

    public function transaction(Closure $closure);
}
