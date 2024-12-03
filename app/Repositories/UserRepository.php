<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{

    public function __construct(
        User $user
    ) {
        $this->model = $user;

        parent::__construct();
    }
}
