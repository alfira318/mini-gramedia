<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $subscriptionPackages = SubscriptionPackage::latest()->take(3)->get();
        $latestBooks = Book::orderBy('created_at', 'desc')->limit(10)->get();
        $freeBooks = Book::where('price', 0)->orderBy('created_at', 'desc')->limit(6)->get();

        return view('home', compact('subscriptionPackages', 'latestBooks', 'freeBooks'));
    }

    public function search(Request $request)
    {

        $query = $request->input('q');

        $books = Book::where('title', 'like', '%' . $query . '%')
            ->orWhere('writer', 'like', '%' . $query . '%')
            ->get();

        return view('search_result', compact('books', 'query'));
    }
}
