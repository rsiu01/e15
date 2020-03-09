<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return view('books.index')->with(['books' => [
             ['title' => 'War and Peace']
             ['title' => 'The Great Gatsby']
        ]]);
    } 

    public function show($title= null)
    {
        # Return a view to show the book
        # Include the book
        //return 'You want to view the details of the book: '.$title;

        $bookFound = false;

        return view('books.show')->with(['title' => $title, 'bookFound' => $bookFound]);
    }

    public function filter($category, $subcategory = null)
    {
        $output = 'Here are all the books under the Category: '.$category;
    
        if ($subcategory) {
            $output .= ' and also the subcategory: '.$subcategory;
        }
    
        return $output;
    }
}
