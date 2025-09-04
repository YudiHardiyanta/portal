<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'satisfaction' => 'required|integer|min:1|max:5',
            'job'          => 'nullable|string|max:255',
            'improvements' => 'nullable|array',
            'message'      => 'nullable|string|max:1000',
        ]);

        Feedback::create($validated);

        return back()->with('success', 'Terima kasih atas feedback Anda!');
    }
}
