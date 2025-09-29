export default function Pengolahan({ metadataKegiatan }) {
    if (!metadataKegiatan)
        return <div className="text-gray-500">Tidak ada data kegiatan.</div>;

    const pengolahanData = [
        ['Tahapan Pengolahan Data', 'tahapan_pengolahan_data'],
        ['Metode Analisis', 'metode_analisis'],
        ['Unit Analisis', 'unit_analisis'],
        ['Tingkat Penyajian Hasil Analisis', 'tingkat_penyajian_hasil_analisis'],
    ];

    const diseminasiHasil = [
        ['Tercetak (hardcopy)', 'ketersediaan_produk_tercetak'],
        ['Digital (softcopy)', 'ketersediaan_produk_digital'],
        ['Data Mikro', 'ketersediaan_produk_mikrodata'],
    ];

    const rencanaRilis = [
        ['Tercetak (hardcopy)', 'rencana_jadwal_rilis_produk_tercetak'],
        ['Digital (softcopy)', 'rencana_jadwal_rilis_produk_digital'],
        ['Data Mikro', 'rencana_jadwal_rilis_produk_mikrodata'],
    ];

    const renderValue = (val) => {
        if (val === true) return "Ya";
        if (val === false) return "Tidak";
        if (Array.isArray(val)) return val.filter(Boolean).join("; ");
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
                <h3 className="mb-3 text-lg font-bold text-gray-900">PENGOLAHAN DAN ANALISIS</h3>
                <div className="divide-y divide-gray-200">{renderFields(pengolahanData)}</div>
            </div>
            <div>
                <h3 className="mb-3 text-lg font-bold text-gray-900">DISEMINASI HASIL</h3>
                <h6 className="mb-1 font-semibold text-gray-900">Produk Kegiatan yang Tersedia untuk Umum</h6>
                <div className="mb-3 divide-y divide-gray-200 text-md">{renderFields(diseminasiHasil)}</div>
                <h6 className="mb-1 font-semibold text-gray-900">Rencana Rilis Produk Kegiatan</h6>
                <div className="divide-y divide-gray-200">{renderFields(rencanaRilis)}</div>
            </div>
        </div>
    );
}