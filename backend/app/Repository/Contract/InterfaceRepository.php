<?php

namespace App\Repository\Contract;

interface InterfaceRepository {
    public function Show();
    public function upload($path);
    public function destroy(int $id);
    public function findOne(int $id);
}
