<?php

namespace App\Repository;

use App\Models\Photo;
use App\Repository\Contract\AbstractRepository;

class PhotoRepository extends AbstractRepository{

    public function __construct()
    {
        $this->model = new Photo();
    }
}
