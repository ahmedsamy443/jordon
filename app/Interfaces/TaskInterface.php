<?php

namespace App\Interfaces;

interface TaskInterface
{
    public function getAlltasks();
    public function getTaskById($id);
    public function deleteTask($id);
    public function updateTask($id, $data);
    public function store($data);
}
