<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Models\Category;

class CategoryRepository extends BaseRepository
{

    public function __construct(
        Category $category
    ) {
        $this->model = $category;

        parent::__construct();
    }
}