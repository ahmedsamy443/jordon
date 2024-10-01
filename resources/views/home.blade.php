@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (Auth::user()->can('insert-tasks'))
                <div>
                    <a href={{ url('tasks/create') }} class="btn btn-success">create</a>
                </div>
            @endif


            <div class="col-md-8">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">title</th>
                            <th scope="col">description</th>
                            <th scope="col">status</th>
                            <th scope="col">created_at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->Description }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->created_at }}</td>
                                @if (Auth::user()->user_type_id == 1)
                                    <td>
                                        <form action="{{ url('assign/task') }}" method="post">
                                            @csrf
                                            <input hidden name="task_id" value="{{$item->id}}">
                                            <select name="employee_id" class="form-select assign_emp">
                                                <option value={{null}}>choose employee</option>
                                                   @foreach ($emloyees as $emp)
                                                       <option {{$emp->id==$item->user_id?'selected':''}}  value="{{ $emp->id }}">{{ $emp->name }}</option>
                                                   @endforeach
                                            </select>
                                        </form>

                                    </td>
                                @endif
                                <td>
                                    <form action="{{ url('status/task') }}" method="post">
                                        @csrf
                                        <input hidden name="task_id" value="{{$item->id}}">
                                        <select name="status" class="form-select change-status">
                                                   <option value={{null}}> status</option>
                                                   <option {{$item->status==='pending'?'selected':''}} value="pending">pending</option>
                                                  <option {{$item->status==='in-progress'?'selected':''}} value="in-progress"> in-progress</option>
                                                  <option {{$item->status==='completed'?'selected':''}} value="completed">completed</option>
                                        </select>
                                    </form>

                                </td>
                                <td>
                                    <a href="{{ route('tasks.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <td>
                                    @if (Auth::user()->can('delete-tasks'))
                                <td>
                                    <div class="col-sm">
                                        <form action="{{ route('tasks.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                <td>
            </div>
            @endif
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
    </div>
    
@endsection

