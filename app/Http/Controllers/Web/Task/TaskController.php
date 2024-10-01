<?php

namespace App\Http\Controllers\Web\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Repositories\TaskRepository;
use App\Enums\UserType;

class TaskController extends Controller
{
    protected static $main_route = 'tasks';

    public function __construct(protected TaskRepository $taskRepository, protected TaskService $taskService) {}
    public function index()
    {

        $items = $this->taskRepository->getAlltasks();
        if (Auth::user()->user_type_id == UserType::USER->value) {
            $items = $items->where('user_id', Auth::id());
        }
        $items = $items->get();
        $emloyees = User::where('user_type_id', UserType::USER->value)->select('id', 'name')->get();
        return view('home', compact('items', 'emloyees'));
    }
    public function create()
    {
        $this->authorize('insert-tasks');
        return view('tasks.create');
    }
    public function store(TaskRequest $request)
    {
        $this->authorize('insert-tasks');
        $data = $request->validated();
        $this->taskRepository->store($data);
        return redirect(url(self::$main_route));
    }
    public function edit($id)
    {
        $item = $this->taskRepository->getTaskById($id);
        if ($item->user_id != Auth::id() && Auth::user()->user_type_id == UserType::USER->value) {
            abort(403);
        }

        return view('tasks.edit', compact('item'));
    }
    public function update(TaskRequest $request, $id)
    {
        $data = $request->validated();
        $this->taskRepository->updateTask($id, $data);
        return redirect(url(self::$main_route));
    }
    public function destroy($id)
    {
        $this->authorize('delete-tasks');
        $items = $this->taskRepository->deleteTask($id);
        return redirect(url(self::$main_route));
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
        $this->taskService->assignEmplyee($data['task_id'], $data['employee_id']);
        return redirect(url(self::$main_route));
    }
    public function changeStatus(Request $request)
    {
        $item = $this->taskRepository->getTaskById($request->task_id);
        if (Auth::user()->user_type_id == UserType::USER->value && $item->user_id != Auth::id()) {
            abort(403);
        }
        if ($item) {
            $this->taskService->changeStatus($item, $request->status);
        }
        return redirect(url(self::$main_route));
    }
}
