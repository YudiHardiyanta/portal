<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndicatorController extends Controller
{
    // Menampilkan daftar indikator + pencarian
    public function index(Request $request)
    {
        $user = $request->user();
        $q = $request->query('q');

        $indicators = Indicator::withCount('likes')
            ->when($q, function ($query, $q) {
                $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('location', 'like', "%{$q}%");
                });
            }) 
            ->latest()
            ->get()
            ->map(function ($indicator) use ($user) {
                $indicator->liked = $user
                    ? $indicator->likes()->where('user_id', $user->id)->exists()
                    : false;
                return $indicator;
            });

        return Inertia::render('Search/Index', [
            'indicators' => $indicators,
            'query' => $q,
            'auth' => [
                'user' => $user,
            ],
        ]);
    }

    // Menambah jumlah view
    public function show(Indicator $indicator)
    {
        $indicator->increment('total_views');

        return Inertia::render('Indicators/Show', [
            'indicator' => $indicator->loadCount('likes'),
        ]);
    }

    // Like indikator
    public function like(Indicator $indicator)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $indicator->likes()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        return back();
    }

    // Unlike indikator
    public function unlike(Indicator $indicator)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $indicator->likes()->where('user_id', $user->id)->delete();

        return back();
    }
}
