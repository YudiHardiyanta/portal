export default function Desain({ metadataKegiatan }) {
    if (!metadataKegiatan)
        return <div className="text-gray-500">Tidak ada data kegiatan.</div>;

    const desainKegiatan = [
        ['Kegiatan Ini Dilakukan', 'kegiatan_ini_dilakukan'],
        ['Frekuensi Penyelenggaraan', 'frekuensi_penyelenggara'],
        ['Cara Pengumpulan Data', 'cara_pengumpulan_data'],
        ['Tipe Pengumpulan Data', 'tipe_pengumpulan_data'],
        ['Cakupan Wilayah Pengumpulan Data', 'cakupan_wilayah_pengumpulan_data'],
        ['Metode Pengumpulan Data', 'metode_pengumpulan_data'],
        ['Sarana Pengumpulan Data', 'sarana_pengumpulan_data'],
        ['Unit Pengumpulan Data', 'unit_pengumpulan_data'],
    ];

    const desainSampel = [
        ['Jenis Rancangan Sampel', 'jenis_rancangan_sampel'],
        ['Metode Pemilihan Sampel Tahap Terakhir', 'metode_pemilihan_sampel_tahap_terakhir'],
        ['Metode yang Digunakan', 'metode_yang_digunakan'],
        ['Unit Sampel', 'unit_sampel'],
        ['Unit Observasi', 'unit_observasi'],
    ];


    const renderFields = (fields) =>
        fields.map(([label, key]) => (
            <div
                key={key}
                className="grid grid-cols-1 gap-1 py-1 border-b border-gray-100 sm:grid-cols-3 sm:gap-4"
            >
                <span className="font-semibold text-gray-800">{label}</span>
                <span className="col-span-2 text-gray-700 break-words">
                    {metadataKegiatan[key] || '-'}
                </span>
            </div>
        ));

    return (
        <div className="space-y-8">
            <div>
                <h3 className="mb-3 text-lg font-bold text-gray-900">DESAIN KEGIATAN</h3>
                <div className="divide-y divide-gray-200">{renderFields(desainKegiatan)}</div>
            </div>

            <div>
                <h3 className="mb-3 text-lg font-bold text-gray-900">DESAIN SAMPEL</h3>
                <div className="divide-y divide-gray-200">{renderFields(desainSampel)}</div>
            </div>

        </div>
    );
}
