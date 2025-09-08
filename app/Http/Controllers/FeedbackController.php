<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use App\Models\Improvement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'satisfaction' => 'required|integer|min:1|max:5',
            'improvements' => 'nullable|array',
            'improvements.*' => 'exists:improvements,id',
            'message' => 'nullable|string|max:1000',
        ]);

        $feedback = Feedback::create([
            'satisfaction' => $validated['satisfaction'],
            'message' => $validated['message'] ?? null,
        ]);

        if (!empty($validated['improvements'])) {
            $feedback->improvements()->sync($validated['improvements']);
        }
        return redirect()->back()->with('success', 'Terima kasih sudah mengisi feedback 🙏');
    }
}
