<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Helpers\JwtHelper;

class IndicatorController extends Controller
{
    // Menampilkan daftar indikator
    public function list(Request $request)
    {
        $user = auth()->user();

        $query = Indicator::query()
            ->select( 'var_id','slug','title', 'sub_id', 'subcsa_id', 'total_views')
            ->with([
                'kategori:id,name',
                'subkategori:id,name',
            ])
            ->withCount('likes');

        if ($request->q) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        if ($request->sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'az') {
            $query->orderBy('title', 'asc');
        } elseif ($request->sort === 'za') {
            $query->orderBy('title', 'desc');
        }

        $indicators = $query->paginate(10)->withQueryString();

        $indicators->getCollection()->transform(function ($indicator) use ($user) {
            return [
                'var_id' => $indicator->var_id,
                'slug' => $indicator->slug,
                'title' => $indicator->title,
                'kategori' => $indicator->kategori?->name,
                'subkategori' => $indicator->subkategori?->name,
                'likes_count' => $indicator->likes_count,
                'total_views' => $indicator->total_views,
                'liked' => $user ? $indicator->likes()->where('user_id', $user->id)->exists() : false,
            ];
        });

        return inertia('Indicators/List', [
            'indicators' => $indicators,
            'query' => $request->q,
            'sort' => $request->sort,
        ]);
    }

    public function show(Indicator $indicator)
    {
        // Tambah jumlah view
        $indicator->increment('total_views');

        $token = JwtHelper::generateToken(
            "e0d77f022c36172beafd31f743aa08e432a150e3d3df880c94ea8a7f3febcb14",
            $indicator->id_dashboard
        );

        $indicator->load([
            'kategori:id,name',
            'subkategori:id,name',
        ])->loadCount('likes');

        $user = auth()->user();

        return Inertia::render('Indicators/Show', [
            'indicator' => [
                'id' => $indicator->var_id,
                'slug' => $indicator->slug,
                'title' => $indicator->title,
                'kategori' => $indicator->kategori?->name,
                'subkategori' => $indicator->subkategori?->name,
                'def' => $indicator->def,
                'notes' => $indicator->notes,
                'unit' => $indicator->unit,
                'views' => $indicator->total_views,
                'likes' => $indicator->likes_count,
                'is_liked' => $user ? $indicator->likes()->where('user_id', $user->id)->exists() : false,
                'id_dashboard' => $indicator->id_dashboard,
            ],
            'token' => $token,
        ]);
    }

    // Like indikator
    public function like(Indicator $indicator)
    {
        $user = auth()->user();
        if (!$user)
            return redirect()->route('login');

        $indicator->likes()->firstOrCreate(
            ['user_id' => $user->id],
            ['indicator_id' => $indicator->var_id]
        );

        return back();
    }

    public function unlike(Indicator $indicator)
    {
        $user = auth()->user();
        if (!$user)
            return redirect()->route('login');

        $indicator->likes()->where('user_id', $user->id)->delete();

        return back();
    }
}
