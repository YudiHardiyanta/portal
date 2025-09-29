export default function PengumpulanData({ metadataKegiatan }) {
    if (!metadataKegiatan)
        return <div className="text-gray-500">Tidak ada data kegiatan.</div>;

    const pengumpulanData = [
        ['Apakah Melakukan Uji Coba (Pilot Survey)', 'apakah_melakukan_uji_coba'],
        ['Metode Pemeriksaan Kualitas Pengumpulan Data', 'metode_pemeriksaan_kualitas_pengumpulan_data'],
        ['Apakah Melakukan Penyesuaian Nonrespon', 'apakah_melakukan_penyesuaian_nonrespon'],
        ['Petugas Pengumpulan Data', 'petugas_pengumpulan_data'],
        ['Persyaratan Pendidikan Terendah Petugas Pengumpulan Data', 'persyaratan_pendidikan_terendah_petugas_pengumpulan_data'],
        ['Apakah Melakukan Pelatihan Petugas', 'apakah_melakukan_pelatihan_petugas'],
    ];

    const pelatihanPetugas = [
        ['Supervisor/penyelia/pengawas', 'jumlah_petugas_supervisor'],
        ['Pengumpul data/enumerator', 'jumlah_petugas_enumerator'],
    ];

    const renderValue = (val) => {
        if (val === true) return "Ya";
        if (val === false) return "Tidak";
        return val || "-";
    };

    const renderFields = (fields) =>
        fields.map(([label, key]) => (
            <div
                key={key}
                className="grid grid-cols-1 gap-1 py-1 border-b border-gray-100 sm:grid-cols-3 sm:gap-4"
            >
                <span className="font-semibold text-gray-800">{label}</span>
                <span className="col-span-2 text-gray-700 break-words">
                    {renderValue(metadataKegiatan[key])}
                </span>
            </div>
        ));

    return (
        <div className="space-y-8">
            <div>
                <h3 className="mb-3 text-lg font-bold text-gray-900">PENGUMPULAN DATA</h3>
                <div className="divide-y divide-gray-200">{renderFields(pengumpulanData)}</div>
            </div>
            <div>
                <h3 className="mb-3 text-lg font-bold text-gray-900">Jumlah Petugas</h3>
                <div className="divide-y divide-gray-200">{renderFields(pelatihanPetugas)}</div>
            </div>
        </div>
    );
}