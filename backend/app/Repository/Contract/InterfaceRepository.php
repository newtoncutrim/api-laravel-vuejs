<?php

namespace App\Repository\Contract;

interface InterfaceRepository {
    public function Show($id);
    public function upload($path, $userId);
    public function destroy(int $id);
    public function findOne(int $id);
    public function new($data);
    public function update($id, $request);
}









