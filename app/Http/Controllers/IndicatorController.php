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
            ->select('var_id', 'slug', 'title', 'sub_id', 'subcsa_id', 'total_views')
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
        $indicator->increment('total_views');

        $token = null;
        if ($indicator->id_dashboard) {
            $token = JwtHelper::generateToken(
                "e0d77f022c36172beafd31f743aa08e432a150e3d3df880c94ea8a7f3febcb14",
                $indicator->id_dashboard
            );
        }

        $indicator->load([
            'kategori:id,name',
            'subkategori:id,name',
            'metadataIndikator.variabel',
            'standarData.konsep',
            'metadataKegiatan'
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
                'standar_data' => $indicator->standarData ? [
                    'id' => $indicator->standarData->id_standar,
                    'nama_data' => $indicator->standarData->nama_data,
                    'definisi' => $indicator->standarData->definisi,
                    'ukuran' => $indicator->standarData->ukuran,
                    'satuan' => $indicator->standarData->satuan,
                    'is_klasifikasi' => $indicator->standarData->is_klasifikasi,
                    'klasifikasi_penyajian' => $indicator->standarData->klasifikasi_penyajian,
                    'klasifikasi_isian' => $indicator->standarData->klasifikasi_isian,
                    'konsep' => $indicator->standarData->konsep->map(fn($k) => [
                        'id' => $k->id_konsep,
                        'kode' => $k->kode_konsep,
                        'konsep' => $k->konsep,
                        'definisi' => $k->definisi,
                    ]),
                ] : null,

                // metadata indikator
                'metadata' => $indicator->metadataIndikator ? [
                    'id' => $indicator->metadataIndikator->id_indikator,
                    'nama_indikator' => $indicator->metadataIndikator->nama_indikator,
                    'konsep' => $indicator->metadataIndikator->konsep,
                    'definisi' => $indicator->metadataIndikator->definisi,
                    'interpretasi' => $indicator->metadataIndikator->interpretasi,
                    'metode_perhitungan' => $indicator->metadataIndikator->metode_perhitungan,
                    'rumus' => $indicator->metadataIndikator->rumus,
                    'ukuran' => $indicator->metadataIndikator->ukuran,
                    'satuan' => $indicator->metadataIndikator->satuan,
                    'variabel_disagregasi' => $indicator->metadataIndikator->variabel_disagregasi ?? [],
                ] : null,

                // metadata variabel 
                'metadata_variabel' => $indicator->metadataIndikator ?
                    $indicator->metadataIndikator->variabel->map(fn($v) => [
                        'id' => $v->id_variabel,
                        'nama_variabel' => $v->nama_variabel,
                        'alias' => $v->alias,
                        'konsep' => $v->konsep,
                        'definisi' => $v->definisi,
                        'satuan' => $v->satuan,
                        'tipe_data' => $v->tipe_data,
                        'is_publik' => $v->is_publik,
                    ])->toArray() : [],

                // metadata kegiatan
                'metadata_kegiatan' => $indicator->metadataKegiatan ? [
                    // Bagian Informasi Umum
                    'judul_kegiatan' => $indicator->metadataKegiatan->judul_kegiatan,
                    'tahun' => $indicator->metadataKegiatan->tahun,
                    'cara_pengumpulan_data' => $indicator->metadataKegiatan->cara_pengumpulan_data,
                    'sektor_kegiatan' => $indicator->metadataKegiatan->sektor_kegiatan,
                    'jenis_statistik' => $indicator->metadataKegiatan->jenis_statistik,
                    'identitas_rekomendasi' => $indicator->metadataKegiatan->identitas_rekomendasi,
                    'latar_belakang_kegiatan' => $indicator->metadataKegiatan->latar_belakang_kegiatan,
                    'tujuan_kegiatan' => $indicator->metadataKegiatan->tujuan_kegiatan,

                    // Bagian Instansi & Penanggung Jawab
                    'instansi_penyelanggara' => $indicator->metadataKegiatan->instansi_penyelanggara,
                    'alamat' => $indicator->metadataKegiatan->alamat,
                    'telepon' => $indicator->metadataKegiatan->telepon,
                    'faksimile' => $indicator->metadataKegiatan->faksimile,
                    'email' => $indicator->metadataKegiatan->email,
                    'unit_eselon1' => $indicator->metadataKegiatan->unit_eselon1,
                    'unit_eselon2' => $indicator->metadataKegiatan->unit_eselon2,
                    'pj_nama' => $indicator->metadataKegiatan->pj_nama,
                    'pj_jabatan' => $indicator->metadataKegiatan->pj_jabatan,
                    'pj_alamat' => $indicator->metadataKegiatan->pj_alamat,
                    'pj_telepon' => $indicator->metadataKegiatan->pj_telepon,
                    'pj_faksimile' => $indicator->metadataKegiatan->pj_faksimile,
                    'pj_email' => $indicator->metadataKegiatan->pj_email,

                    // Bagian Jadwal Kegiatan
                    'mulai_jadwal_perencanaan_kegiatan' => $indicator->metadataKegiatan->mulai_jadwal_perencanaan_kegiatan,
                    'selesai_jadwal_perencanaan_kegiatan' => $indicator->metadataKegiatan->selesai_jadwal_perencanaan_kegiatan,
                    'mulai_jadwal_desain' => $indicator->metadataKegiatan->mulai_jadwal_desain,
                    'selesai_jadwal_desain' => $indicator->metadataKegiatan->selesai_jadwal_desain,
                    'mulai_jadwal_pengumpulan_data' => $indicator->metadataKegiatan->mulai_jadwal_pengumpulan_data,
                    'selesai_jadwal_pengumpulan_data' => $indicator->metadataKegiatan->selesai_jadwal_pengumpulan_data,
                    'mulai_jadwal_pengolahan_data' => $indicator->metadataKegiatan->mulai_jadwal_pengolahan_data,
                    'selesai_jadwal_pengolahan_data' => $indicator->metadataKegiatan->selesai_jadwal_pengolahan_data,
                    'mulai_jadwal_analisis' => $indicator->metadataKegiatan->mulai_jadwal_analisis,
                    'selesai_jadwal_analisis' => $indicator->metadataKegiatan->selesai_jadwal_analisis,
                    'mulai_jadwal_diseminasi_hasil' => $indicator->metadataKegiatan->mulai_jadwal_diseminasi_hasil,
                    'selesai_jadwal_diseminasi_hasil' => $indicator->metadataKegiatan->selesai_jadwal_diseminasi_hasil,
                    'mulai_jadwal_evaluasi' => $indicator->metadataKegiatan->mulai_jadwal_evaluasi,
                    'selesai_jadwal_evaluasi' => $indicator->metadataKegiatan->selesai_jadwal_evaluasi,

                    // Bagian Pengumpulan Data
                    'kegiatan_ini_dilakukan' => $indicator->metadataKegiatan->kegiatan_ini_dilakukan,
                    'frekuensi_penyelenggara' => $indicator->metadataKegiatan->frekuensi_penyelenggara,
                    'tipe_pengumpulan_data' => $indicator->metadataKegiatan->tipe_pengumpulan_data,
                    'cakupan_wilayah_pengumpulan_data' => $indicator->metadataKegiatan->cakupan_wilayah_pengumpulan_data,
                    'metode_pengumpulan_data' => $indicator->metadataKegiatan->metode_pengumpulan_data,
                    'sarana_pengumpulan_data' => $indicator->metadataKegiatan->sarana_pengumpulan_data,
                    'unit_pengumpulan_data' => $indicator->metadataKegiatan->unit_pengumpulan_data,
                    'metode_pemeriksaan_kualitas_pengumpulan_data' => $indicator->metadataKegiatan->metode_pemeriksaan_kualitas_pengumpulan_data,
                    'petugas_pengumpulan_data' => $indicator->metadataKegiatan->petugas_pengumpulan_data,
                    'persyaratan_pendidikan_terendah_petugas_pengumpulan_data' => $indicator->metadataKegiatan->persyaratan_pendidikan_terendah_petugas_pengumpulan_data,
                    'jumlah_petugas_supervisor' => $indicator->metadataKegiatan->jumlah_petugas_supervisor,
                    'jumlah_petugas_enumerator' => $indicator->metadataKegiatan->jumlah_petugas_enumerator,
                    'apakah_melakukan_pelatihan_petugas' => $indicator->metadataKegiatan->apakah_melakukan_pelatihan_petugas,
                    'apakah_melakukan_uji_coba' => $indicator->metadataKegiatan->apakah_melakukan_uji_coba,

                    // Bagian Desain Sampel
                    'jenis_rancangan_sampel' => $indicator->metadataKegiatan->jenis_rancangan_sampel,
                    'metode_pemilihan_sampel_tahap_terakhir' => $indicator->metadataKegiatan->metode_pemilihan_sampel_tahap_terakhir,
                    'metode_yang_digunakan' => $indicator->metadataKegiatan->metode_yang_digunakan,
                    'unit_sampel' => $indicator->metadataKegiatan->unit_sampel,
                    'unit_observasi' => $indicator->metadataKegiatan->unit_observasi,
                    'apakah_melakukan_penyesuaian_nonrespon' => $indicator->metadataKegiatan->apakah_melakukan_penyesuaian_nonrespon,

                    // Bagian Pengolahan & Analisis
                    'tahapan_pengolahan_data' => $indicator->metadataKegiatan->tahapan_pengolahan_data,
                    'metode_analisis' => $indicator->metadataKegiatan->metode_analisis,
                    'unit_analisis' => $indicator->metadataKegiatan->unit_analisis,
                    'tingkat_penyajian_hasil_analisis' => $indicator->metadataKegiatan->tingkat_penyajian_hasil_analisis,

                    // Bagian Diseminasi
                    'ketersediaan_produk_tercetak' => $indicator->metadataKegiatan->ketersediaan_produk_tercetak,
                    'ketersediaan_produk_digital' => $indicator->metadataKegiatan->ketersediaan_produk_digital,
                    'ketersediaan_produk_mikrodata' => $indicator->metadataKegiatan->ketersediaan_produk_mikrodata,
                    'rencana_jadwal_rilis_produk_tercetak' => $indicator->metadataKegiatan->rencana_jadwal_rilis_produk_tercetak,
                    'rencana_jadwal_rilis_produk_digital' => $indicator->metadataKegiatan->rencana_jadwal_rilis_produk_digital,
                    'rencana_jadwal_rilis_produk_mikrodata' => $indicator->metadataKegiatan->rencana_jadwal_rilis_produk_mikrodata,

                ] : null,
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
