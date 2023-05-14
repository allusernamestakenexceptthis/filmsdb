<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

use App\Repositories\interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Movies interface for repositories to implement
 */
class BaseRepository implements BaseInterface
{

    /**
     * Model to be injected
     *
     * @var Model
     */
    protected Model $model;

    protected int $perPage = 20;
    protected array $columns = ['*'];
    protected array $with = [];
    protected array $orders = [];
    protected array $fillables = [];


    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    
    /**
     * Create a record
     * 
     * @param array<string, mixed> $attributes
     * 
     * @return mixed
     */
    public function create(array $attributes): mixed {
        return $this->model->fill($attributes);
    }

    /**
     * Update a record
     * 
     * @param integer $id
     * @param array<string, mixed> $attributes
     * 
     * @return boolean
     */
    public function update(int $id, array $attributes): bool {
        return $this->model->find($id)->update($attributes) ?? false;
    }

    /**
     * Delete record
     *
     * @param integer $id
     * 
     * @return boolean
     */
    public function delete(int $id): bool {
        return $this->model->find($id)->delete() ?? false;
    }

    /**
     * Find record by id
     *
     * @param integer $id
     * 
     * @return mixed
     */
    public function find(int $id): mixed {
        return $this->model->find($id, $this->columns, $this->with);
    }

    /**
     * Find by query
     * 
     * @param array<string, mixed> $attributes
     * 
     * @return mixed
     */
    public function findBy(array $attributes): LengthAwarePaginator {
        return $this->all($attributes);
    }

    /**
     * get all records with pagination
     *
     * @return LengthAwarePaginator
     */
    public function all(array $attributes = array()): LengthAwarePaginator /* throws \Exception */ {
        $query = $this->model->query();
        return $this->processQuery($query, $attributes);
    }

    /**
     * Centralize query processing to enable pagination and search in one place
     *
     * @param Builder $query
     * @param array $attributes
     * 
     * @return LengthAwarePaginator
     */
    public function processQuery(Builder $query, array $attributes = array()): LengthAwarePaginator /* throws \Exception */ {
        $query->select($this->columns);
        $query->with($this->with);
        if ($this->orders) {
            foreach ($this->orders as $order) {
                if (isset($order[1]) && !in_array($order[1], ['asc', 'desc'])) {
                    throw new \Exception(__("Invalid order direction :direction", ['direction'=>e($order[1])]));
                }
                $query->orderBy(...$order);
            }
        }

        if ($attributes) {
            if (!is_array($attributes[0])) {
                $attributes = [$attributes];
            }

            foreach ($attributes as $attribute) {
                $query->where($attribute[0], "like", '%'.$attribute[1].'%');
            }
        }

        if ($invalidAttribute = $this->checkForInvalidAttribute($attributes, $this->orders)) {
            throw new \Exception(__("Invalid attributes :attribute_name", ['attribute_name'=>e($invalidAttribute)]));
        }

        return $query->paginate($this->perPage);
    }

    /**
     * Set the per page value
     *
     * @param integer $perPage
     * 
     * @return self
     */
    public function setPerPage(int $perPage): self {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Set the columns value
     *
     * @param array<string> $columns
     * 
     * @return self
     */
    public function setColumns(array $columns): self {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Set the with value
     *
     * @param array<string> $with
     * 
     * @return self
     */
    public function setWith(array $with): self {
        $this->with = $with;
        return $this;
    }

    /**
     * Set the orders value
     *
     * @param array<string> $orders
     * 
     * @return self
     */
    public function setOrders(array $orders): self {
        $this->orders[] = $orders;
        return $this;
    }

    /**
     * Check if attributes exists in model
     * 
     * @param array<string, mixed> $attributes
     * 
     * @return boolean
     */
    public function checkForInvalidAttribute(array $attributes, array $orders = []) {
        //merge attributes and orders
        $attributes = array_merge($attributes, $orders);

        //if no attributes means no invalid attribute
        if (!$attributes) {
            return false;
        }

        foreach ($attributes as $attribute) {
            if (!in_array(strtolower($attribute[0]), $this->getFillable())) {
                return $attribute[0];
            }
        }
        return false;
    }

    /**
     * Get the fillable attributes
     *
     * @return array<string> $fillable
     */
    public function getFillable() : array {
        if ($this->fillables) {
            return $this->fillables;
        } else {
            return $this->model->getFillable();
        }
    }

    /**
     * Set the fillable attributes
     *
     * @param array<string> $fillables
     * 
     * @return self
     */
    public function setFillable(array $fillables) : self {
        $this->fillables = $fillables;
        return $this;
    }
}