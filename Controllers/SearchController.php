<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\CategoryFile;
use App\Models\Source;
use App\Models\Unitkerja;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the search.
     *
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        if(!empty($request->name)){
            $name = $request->name;
            // $categories = DB::table('categories')
            // ->join('category_files', 'categories.id', '=', 'category_files.category_id')
            // ->select('categories.*', DB::raw('category_files.name data'))
            // ->where('category_files.name', 'like', '%' .$name. '%')
            // ->paginate(10);

            $data = CategoryFile::select('categories.*', DB::raw('category_files.name data'), DB::raw('sources.name source'))
                    ->leftJoin('categories', 'categories.id', 'category_files.category_id')
                    ->leftJoin('metadatas', 'metadatas.category_id', 'categories.id')
                    ->leftJoin('sources', 'sources.id', 'metadatas.source_id')
                    ->leftJoin('category_tags', 'category_tags.category_id', 'categories.id')
                    ->leftJoin('tags', 'tags.id', 'category_tags.tag_id')
                    ->whereNull('categories.deleted_at')
                    ->whereNull('sources.deleted_at')
                    ->where(function($query) use ($name) {
                        $query
                        ->where('category_files.name', 'like', '%' .$name. '%')
                        ->orwhere('tags.tag', 'like', '%'.$name.'%')
                        ->orwhere('categories.name', 'like', '%'.$name.'%');
                    })
                    ->groupby('category_files.id')
                    ->paginate(10);
            return view('pages.search.index', ['categories' => $data]);
        }else{
            return view('pages.search.index', ['categories' => array() ]);
        }
        
    }

}
