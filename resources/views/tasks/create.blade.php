@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class='row'>
                <form method="post" action="{{ url('tasks') }}">
                    @csrf
                    <div class="form-group m-4">
                        <label for="exampleInputEmail1">title</label>
                        <input type="text" name="title" class="form-control" aria-describedby="emailHelp"
                            placeholder="Enter title">
                    </div>
                    @if ($errors->has('title'))
                        <span class='text-danger'>{{ $errors->first('title') }}</span>
                    @endif
                    <div class="form-group m-4">
                        <label for="exampleInputEmail1">Description</label>
                        <input type="text" name="Description" class="form-control" aria-describedby="emailHelp"
                            placeholder="Enter Description">
                    </div>
                    @if ($errors->has('Description'))
                        <span class='text-danger'>{{ $errors->first('Description') }}</span>
                    @endif
                    <div class="form-group m-4">
                        <button type="submit" class="btn btn-primary">Submit</button>

                    </div>
                </form>
            </div>
        </div>
    @endsection
