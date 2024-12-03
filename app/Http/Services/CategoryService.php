<?php

namespace App\Http\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {
    }

    /**
     * List all cart rules
     *
     * @param array $filterable
     * @param array $relationships
     * @return object
     */
    public function index(array $filterable, array $relationships = []): object
    {
        $categories = $this->categoryRepository->fetchAll($filterable, $relationships);

        return $categories;
    }

    /**
     * Store cart rule
     *
     * @param array $data
     * @return Category
     */
    public function store(array $data): Category
    {
        $category = $this->categoryRepository->store($data);

        return $category;
    }

    /**
     * Show Category
     *
     * @param string $CategoryId
     * @param array $relationships
     * @return Category
     */
    public function show(string $categoryId, array $relationships = []): Category
    {
        $category = $this->categoryRepository->fetch($categoryId, $relationships);

        return $category;
    }

    /**
     * Update Category
     *
     * @param string $CategoryId
     * @param array $data
     * @return Category
     */
    public function update(string $categoryId, array $data): Category
    {
        $category = $this->categoryRepository->update($data, $categoryId);

        return $category;
    }

    /**
     * Deletes an existing cart rule
     *
     * @param string $category
     * @return void
     */
    public function delete(string $categoryId): void
    {
        $this->categoryRepository->fetch($categoryId);
        $this->categoryRepository->delete($categoryId);
    }
}
