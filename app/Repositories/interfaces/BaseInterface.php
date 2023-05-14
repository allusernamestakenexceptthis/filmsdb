<?php

declare(strict_types=1);

namespace App\Repositories\interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Base interface for repositories to implement
 */
interface BaseInterface
{
    /**
     * Create a record
     * 
     * @param array<string, mixed> $attributes
     * 
     * @return mixed
     */
    public function create(array $attributes): mixed;

    /**
     * Update a record
     * 
     * @param integer $id
     * @param array<string, mixed> $attributes
     * 
     * @return boolean
     */
    public function update(int $id, array $attributes): bool;

    /**
     * Delete record
     *
     * @param integer $id
     * 
     * @return boolean
     */
    public function delete(int $id): bool;

    /**
     * Find record by id
     *
     * @param integer $id
     * 
     * @return mixed
     */
    public function find(int $id): mixed;

    /**
     * get all records with pagination
     *
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator;
}