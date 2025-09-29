export default function InformasiUmum({ metadataKegiatan }) {
    if (!metadataKegiatan)
        return <div className="text-gray-500">Tidak ada data kegiatan.</div>;

    const infoUmum = [
        ['Judul Kegiatan', 'judul_kegiatan'],
        ['Tahun Kegiatan', 'tahun'],
        ['Cara Pengumpulan Data', 'cara_pengumpulan_data'],
        ['Sektor Kegiatan', 'sektor_kegiatan'],
        ['Jenis Kegiatan Statistik', 'jenis_statistik'],
        ['Identitas Rekomendasi', 'identitas_rekomendasi'],
    ];

    const penyelenggara = [
        ['Instansi Penyelenggara', 'instansi_penyelanggara'],
        ['Alamat Lengkap', 'alamat'],
        ['Telepon', 'telepon'],
        ['Faksimile', 'faksimile'],
        ['Email', 'email'],
        ['Unit Eselon 1', 'unit_eselon1'],
        ['Unit Eselon 2', 'unit_eselon2'],
    ];

    const penanggungJawab = [
        ['Nama', 'pj_nama'],
        ['Jabatan', 'pj_jabatan'],
        ['Alamat', 'pj_alamat'],
        ['Telepon', 'pj_telepon'],
        ['Faksimile', 'pj_faksimile'],
        ['Email', 'pj_email'],
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
                <h3 className="mb-3 text-lg font-bold text-gray-900">INFORMASI UMUM</h3>
                <div className="divide-y divide-gray-200">{renderFields(infoUmum)}</div>
            </div>

            <div>
                <h3 className="mb-3 text-lg font-bold text-gray-900">PENYELENGGARA</h3>
                <div className="divide-y divide-gray-200">{renderFields(penyelenggara)}</div>
            </div>

            <div>
                <h3 className="mb-3 text-lg font-bold text-gray-900">PENANGGUNG JAWAB</h3>
                <div className="divide-y divide-gray-200">{renderFields(penanggungJawab)}</div>
            </div>
        </div>
    );
}
