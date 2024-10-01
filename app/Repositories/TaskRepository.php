<?php

namespace app\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskRepository implements TaskInterface
{
    public function getAlltasks()
    {
        $items = Task::query();
        return $items;
    }

    public function getTaskById($id)
    {
        return Task::findOrFail($id);
    }

    public function deleteTask($id)
    {
        Task::destroy($id);
    }
    public function store($data)
    {
      Task::create($data);
    }
    public function updateTask($id,$data)
    {
        Task::findOrFail($id)->update($data);
    }
}
