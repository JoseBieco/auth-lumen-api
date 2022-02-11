<?php

namespace  App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    /**
     * Get all entities from model Author
     */
    function getAllAuthors()
    {
        return response()->json(Author::all());
    }

    /**
     * Get one entity from model Author by id
     * @param $id int Author identifier
     */
    function getAuthorById($id)
    {
        return response()->json(Author::find($id));
    }

    /**
     * Create new entity for model Author
     * @param $request Author
     */
    function create(Request $request)
    {
        $this->validate($request, $this->validateData());

        $author = Author::create($request->all());

        return response()->json($author, 201);
    }

    /**
     * Update entity from model Author
     * @param $id int Author identifier
     * @param $request Author
     */
    function update($id, Request $request)
    {
        $author = Author::findOrFail($id);

        $author->update($request->all());

        return response()->json($author, 200);
    }

    /**
     * Delete one entity from model Author by id
     * @param $id int Author identifier
     */
    function delete($id)
    {
        Author::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    /**
     * Return the validations of the obligatory fields from Author model
     */
    private function validateData()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:authors'
        ];
    }
}
