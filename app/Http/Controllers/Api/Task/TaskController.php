<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use  App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TaskRepository;
use Validator;
use App\Enums\UserType;


class TaskController extends Controller
{
    private $taskRepository;
    private $taskService;
    public function __construct(TaskRepository $taskRepository, TaskService $taskService)
    {
        $this->taskRepository = $taskRepository;
        $this->taskService = $taskService;
    }
    public function index()
    {
        $items = $this->taskRepository->getAlltasks();
        // check if auth user is admin or user with user_type_id
        if (Auth::user()->user_type_id ==  UserType::USER->value) 
        {
            $items = $items->where('user_id', Auth::id());
        }
        $items = $items->get();
        return $this->sendexternalResponse('success', $items, 201);
    }
    public function store(TaskRequest $request)
    {
        // check user has permissions to create tasks 
        $this->authorize('insert-tasks');
        $data = $request->validated();
        // call repo store fun
        $this->taskRepository->store($data);
        return $this->sendexternalResponse('success', [], 201);
    }
    public function show($id)
    {
        // call repo getbyid fun
        $item = $this->taskRepository->getTaskById($id);
        // forbidden user if task not assiend for him to see task
        if ($item->user_id != Auth::id() && Auth::user()->user_type_id ==  UserType::USER->value) {
            return $this->sendexternalResponse('forbidden', [], 403);
        }

        return $this->sendexternalResponse('success', $item, 201);
    }
    public function update(TaskRequest $request, $id)
    {
        $data = $request->validated();
        $this->taskRepository->updateTask($id, $data);
        return $this->sendexternalResponse('success', [], 201);
    }
    public function destroy($id)
    {
        // check if auth user has permissions to ddelete tasks
        if (Auth::user()->cannot('delete-tasks')) 
        {
            return $this->sendexternalResponse('forbidden', [], 403);
        }
        $this->taskRepository->deleteTask($id);
        return $this->sendexternalResponse('success', [], 201);
    }
    public function assign(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'task_id' => 'required',
                'employee_id' => 'required',
            ]
        );
        $data = $validation->validated();
        // fetch assisn fun in service class
        $this->taskService->assignEmplyee($data['task_id'], $data['employee_id']);
        return $this->sendexternalResponse('success', [], 201);
    }
    public function changeStatus(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'task_id' => 'required',
                'status' => 'required',
            ]
        );
        $data = $validation->validated();
        $item = task::findOrFail($data['task_id']);
        if (Auth::user()->user_type_id ==  UserType::USER->value && $item->user_id != Auth::id()) {
            abort(403);
        }
        if ($item) {
            $this->taskService->changeStatus($item, $request->status);
        }
        return $this->sendexternalResponse('success', [], 201);
    }
}
