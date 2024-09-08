<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Todo</title>
    <style>
        .btn-space {
            margin-right: 10px;
            /* Adjust the spacing as needed */
        }

        .status {
            margin-right: 10%;
        }
        .categ{
            margin-right: 10px;
        }

        .checkbox {
            margin-right: 90px;
            /* Make the checkbox larger */
            transform: scale(1.5);
            /* You can change 1.5 to any other value to adjust the size */
            -webkit-transform: scale(1.5);
            /* For Safari compatibility */
        }
    </style>
</head>

<body>
    <div class="container m-5 p-2 rounded mx-auto bg-light shadow">
        <!-- App title section -->
        <div class="row m-1 p-4">
            <div class="col">
                <div class="p-1 h1 text-primary text-center mx-auto display-inline-block">
                    <i class="fa fa-check bg-primary text-white rounded p-2"></i>
                    <a href="{{url('/')}}"><u>My Todo-s</u></a>
                </div>
            </div>
        </div>
        <!-- Create todo section -->
        <form action="{{ route('create_todo') }}" method="POST">
            @csrf
            <div class="row m-1 p-3">
                <div class="col col-11 mx-auto">
                    <div
                        class="row bg-white rounded shadow-sm p-2 add-todo-wrapper align-items-center justify-content-center">
                        <div class="col">
                            <input class="form-control form-control-lg border-0 add-todo-input bg-transparent rounded"
                                name="text" type="text" placeholder="Add new ..">
                        </div>
                        <div class="col-auto m-0 px-2 d-flex align-items-center">
                            <label class="text-secondary my-2 p-0 px-1 view-opt-label due-date-label d-none">Due date
                                not set</label>
                            <i class="fa fa-calendar my-2 px-1 text-primary btn due-date-button" data-toggle="tooltip"
                                data-placement="bottom" title="Set a Due date"></i>
                            <i class="fa fa-calendar-times-o my-2 px-1 text-danger btn clear-due-date-button d-none"
                                data-toggle="tooltip" data-placement="bottom" title="Clear Due date"></i>
                        </div>
                        <div class="col-auto px-0 mx-0 mr-2">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                        <label class=" my-2 pr-1 view-opt-label">Category</label>
                        <select required name="category" class="custom-select custom-select-sm btn my-2">
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <div class="p-2 mx-4 border-black-25 border-bottom"></div>
        <!-- View options section -->
        <div class="row m-1 p-3 px-5 justify-content-end">
            <div class="col-auto d-flex align-items-center">
                <label class="text-secondary my-2 pr-2 view-opt-label">Filter</label>
                <select class="custom-select custom-select-sm btn my-2">
                    <option value="all" selected>All</option>
                    <option value="completed">Completed</option>
                    <option value="active">Active</option>
                    <option value="has-due-date">Has due date</option>
                </select>
            </div>
            <div class="col-auto d-flex align-items-center px-1 pr-3">
                <label class="text-secondary my-2 pr-2 view-opt-label">Sort</label>
                <select class="custom-select custom-select-sm btn my-2">
                    <option value="added-date-asc" selected>Added date</option>
                    <option value="due-date-desc">Due date</option>
                </select>
                <i class="fa fa fa-sort-amount-asc text-info btn mx-0 px-0 pl-1" data-toggle="tooltip"
                    data-placement="bottom" title="Ascending"></i>
                <i class="fa fa fa-sort-amount-desc text-info btn mx-0 px-0 pl-1 d-none" data-toggle="tooltip"
                    data-placement="bottom" title="Descending"></i>
            </div>
        </div>
        <!-- Todo list section -->
        <div class="row mx-1 px-5 pb-3 w-80">
            <div class="col mx-auto">
                <!-- Todo Item 1 -->

                @foreach ($todo_list as $item)
                    <form id="statusForm{{ $item->id }}" action="{{ route('Update_todo', $item->id) }}"
                        method="POST">
                        @csrf
                        <div class="row px-3 align-items-center todo-item rounded">
                            <div class="col-auto m-1 p-0 d-flex align-items-center">
                                <h2 class="m-0 p-0">
                                    <i class="fa fa-square-o text-primary btn m-0 p-0 d-none" data-toggle="tooltip"
                                        data-placement="bottom" title="Mark as complete"></i>
                                    <i class="fa fa-check-square-o text-primary btn m-0 p-0" data-toggle="tooltip"
                                        data-placement="bottom" title="Mark as todo"></i>
                                </h2>
                            </div>
                            <div class="col px-1 m-1 d-flex align-items-center">
                                <input type="text"
                                    class="form-control form-control-lg border-0 edit-todo-input bg-transparent rounded px-3"
                                    readonly value="{{ $item->text }}" title="{{ $item->text }}" />
                                <input type="text"
                                    class="form-control form-control-lg border-0 edit-todo-input rounded px-3 d-none"
                                    value="{{ $item->text }}" />


                                <!--  Update Todo Category -->
                                @if ($item->category->name == 'Work')
                                    <button type="button"
                                        class="btn btn-danger col-1 categ ">{{ $item->category->name }}</button>
                                @else
                                    <button type="button"
                                        class="btn btn-info col-1 categ ">{{ $item->category->name }}</button>
                                @endif



                                @if ($item->status == 'Active')
                                    <button type="button"
                                        class="btn btn-warning col-2 status">{{ $item->status }}</button>
                                @else
                                    <button type="button"
                                        class="btn btn-success col-2 status">{{ $item->status }}</button>
                                @endif

                                <input type="hidden" name="status" value="0">
                                <!-- This is sent when unchecked -->
                                <input type="checkbox" name="status" class="checkbox"
                                    id="statusCheckbox{{ $item->id }}" value="1"
                                    {{ $item->status == 'Complete' ? 'checked' : '' }}
                                    onchange="document.getElementById('statusForm{{ $item->id }}').submit();">
                                <a href="{{ route('update_todo_list', $item->id) }}"
                                    class="btn btn-primary btn-space">Update</a>
                                <a href="{{ route('delete_todo_list', $item->id) }}" class="btn btn-danger">Delete</a>



                            </div>
                            <div class="col-auto m-1 p-0 px-3 d-none">

                            </div>
                            <div class="col-auto m-1 p-0 todo-actions">
                                <div class="row d-flex align-items-center justify-content-end">
                                    <h5 class="m-0 p-0 px-2">
                                        <i class="fa fa-pencil text-info btn m-0 p-0" data-toggle="tooltip"
                                            data-placement="bottom" title="Edit todo"></i>
                                    </h5>
                                    <h5 class="m-0 p-0 px-2">
                                        <i class="fa fa-trash-o text-danger btn m-0 p-0" data-toggle="tooltip"
                                            data-placement="bottom" title="Delete todo"></i>
                                    </h5>
                                </div>
                                <div class="row todo-created-info">
                                    <div class="col-auto d-flex align-items-center pr-2">
                                        <i class="fa fa-info-circle my-2 px-2 text-black-50 btn" data-toggle="tooltip"
                                            data-placement="bottom" title=""
                                            data-original-title="Created date"></i>
                                        <label class="date-label my-2 text-black-50">{{ $item->date }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="home/index.js"></script>
</body>

</html>