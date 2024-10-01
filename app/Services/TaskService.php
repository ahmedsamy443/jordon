<?php

namespace App\Services;
use App\Models\Task;
class TaskService
{
    public function changeStatus($item,$status)
    {
        $item->update([
            'status'=>$status
           ]);
    }
    public function assignEmplyee($task_id, $emplyee_id)
    {
        $item = task::findOrFail($task_id);
        if ($item) {
            $item->update([
                'user_id' => $emplyee_id
            ]);
        }
    }
  

}
