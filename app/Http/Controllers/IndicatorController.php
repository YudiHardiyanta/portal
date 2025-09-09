<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndicatorController extends Controller
{
    // Menampilkan daftar indikator
    public function index(Request $request)
    {
        $query = Indicator::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        if ($request->sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'az') {
            $query->orderBy('name', 'asc');
        } elseif ($request->sort === 'za') {
            $query->orderBy('name', 'desc');
        }

        $indicators = $query->paginate(10)->withQueryString();

        return inertia('Search/Index', [
            'indicators' => $indicators,
            'query' => $request->q,
            'sort' => $request->sort,
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
