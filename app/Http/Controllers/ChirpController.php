<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    public function index()
    {
        $chirps = Chirp::with('user')
            ->latest()
            ->take(50)  // Limit to 50 most recent chirps
            ->get();

        return view('home', ['chirps' => $chirps]);
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
        'message' => [
            'required',
            'string',
            'max:255',
            Rule::unique('chirps')->where(function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
        ],
    ]);

        return redirect('/')->with('success', 'Your chirp has been posted!');
    }
}