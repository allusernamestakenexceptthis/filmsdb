<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

use App\Repositories\interfaces\BaseInterface;

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

    protected int $perPage = 10;
    protected array $columns = ['*'];
    protected array $with = [];
    protected array $orders = [];


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
    public function all(array $attributes = null): LengthAwarePaginator /* throws \Exception */ {
        $query = $this->model->query();
        $query->select($this->columns);
        $query->with($this->with);
        if ($this->orders) {
            $query->orderBy(...$this->orders);
        }

        if ($attributes) {

            if (!is_array($attributes[0])) {
                $attributes = [$attributes];
            }

            if (!$this->checkIfAttributesExists($attributes)) {
                throw new \Exception("Invalid attributes");
            }

            foreach ($attributes as $attribute) {
                $query->where($attribute[0], "like", '%'.$attribute[1].'%');
            }
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
        $this->orders = $orders;
        return $this;
    }

    /**
     * Check if attributes exists in model
     * 
     * @param array<string, mixed> $attributes
     * 
     * @return boolean
     */
    public function checkIfAttributesExists($attributes) {
        foreach ($attributes as $attribute) {
            if (!in_array($attribute[0], $this->model->getFillable())) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the fillable attributes
     *
     * @return array<string> $fillable
     */
    public function getFillable() : array {
        return $this->model->getFillable();
    }
}