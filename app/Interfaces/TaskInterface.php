<?php

namespace App\Interfaces;

interface TaskInterface 
{
    public function getAlltasks();
    public function getTaskById($id);
    public function deleteTask($id);
    // public function createTask( $data);
     public function updateTask($id,$data);
}