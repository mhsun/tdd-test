<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();

        return response()->json([
            'data' => $todos
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ], [
            'title.required' => "abul babul"
        ]);

        $todo = Todo::create($request->all());

        return response()->json([
            'data' => $todo
        ], 201);
    }

    public function update(Request $request, Todo $todo)
    {
        $todo->update($request->all());

        return response()->json([
            'data' => $todo->refresh()
        ]);
    }
}
