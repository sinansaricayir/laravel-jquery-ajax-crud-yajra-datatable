<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::all();
        if ($request->ajax()) {
            return DataTables::of($categories)
                ->addColumn('action', function () {
                    return '<a href class="btn btn-info">edit</a>';
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:30',
            'type' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
            'type' => $request->type
        ]);

        return response()->json([
            'success' => 'Category Saved Successfully'
        ], 201);
    }
}
