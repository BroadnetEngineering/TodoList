<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * TodoList CRUD methods
 */
class TodoListController extends Controller
{
    /**
     * Display all TodoList records.
     *
     * @return TodoList[]
     */
    public function index(): array
    {
        return TodoList::all()->toArray();
    }

    /**
     * Create a new TodoList.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TodoList
     */
    public function store(Request $request): TodoList
    {
        // Ensure name is provided and unique
        $this->validateName($request);

        return TodoList::create($request->all());
    }

    /**
     * Display the specified TodoList by ID.
     *
     * @param  int  $id
     * @return TodoList
     */
    public function show(int $id): TodoList
    {
        return TodoList::find($id);
    }

    /**
     * Display the specified TodoList by name
     * 
     * @param string $name
     * @return TodoList|null
     */
    public function showByName(string $name): ?Collection
    {
        return TodoList::where('name', $name)->get();
    }

    /**
     * Get a TodoList and update it.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return TodoList
     */
    public function update(Request $request, int $id): TodoList
    {
        // Ensure name is provided and unique
        $this->validateName($request);
    
        $todoList = TodoList::find($id);
        $todoList->update($request->all());

        return $todoList;
    }

    /**
     * Delete a TodoList.
     *
     * @param  int  $id
     * @return string
     */
    public function destroy(int $id): string
    {
        $list = TodoList::find($id);
        TodoList::destroy($list->id);

        $message = sprintf(
            'Deleted list: %s',
            $list->name
        );

        return $message;
    }

    /**
     * Validate the name field is provided and unique
     * 
     * @param Request $request
     * @return array
     */
    private function validateName(Request $request)
    {
        return $request->validate([
            'name' => [
                'required',
                Rule::unique(TodoList::TABLE_NAME)
            ]
        ]);
    }
}
