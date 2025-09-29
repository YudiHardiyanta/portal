const formatDate = (dateString) => {
    if (!dateString) return '-';
    return dateString.slice(0, 10);
};

export default function Perencanaan({ metadataKegiatan }) {
    if (!metadataKegiatan) {
        return <div className="text-gray-500">Tidak ada data metadata kegiatan.</div>;
    }
    
    const infoUmum = [
        ['Latar Belakang', 'latar_belakang_kegiatan'],
        ['Tujuan Kegiatan', 'tujuan_kegiatan'],
    ];

    const jadwal = [
        ['Perencanaan Kegiatan', 'mulai_jadwal_perencanaan_kegiatan', 'selesai_jadwal_perencanaan_kegiatan'],
        ['Desain', 'mulai_jadwal_desain', 'selesai_jadwal_desain'],
        ['Pengumpulan Data', 'mulai_jadwal_pengumpulan_data', 'selesai_jadwal_pengumpulan_data'],
        ['Pengolahan Data', 'mulai_jadwal_pengolahan_data', 'selesai_jadwal_pengolahan_data'],
        ['Analisis', 'mulai_jadwal_analisis', 'selesai_jadwal_analisis'],
        ['Diseminasi Hasil', 'mulai_jadwal_diseminasi_hasil', 'selesai_jadwal_diseminasi_hasil'],
        ['Evaluasi', 'mulai_jadwal_evaluasi', 'selesai_jadwal_evaluasi'],
    ];

    const renderFields = (fields) =>
        fields.map(([label, key], index, array) => (
            <div
                key={key}
                className={`grid grid-cols-1 gap-1 py-1 sm:grid-cols-3 sm:gap-4 ${
                    index === array.length - 1 ? '' : 'border-b-2 border-gray-100'
                }`}
            >
                <span className="font-semibold text-gray-800">{label}</span>
                <span className="col-span-2 text-gray-700 break-words">
                    {metadataKegiatan[key] || '-'}
                </span>
            </div>
        ));

    const renderJadwal = (fields) =>
        fields.map(([label, startKey, endKey], index, array) => {
            const startDate = formatDate(metadataKegiatan[startKey]);
            const endDate = formatDate(metadataKegiatan[endKey]);
            if (startDate === '-' && endDate === '-') {
                return null;
            }

            return (
                <div
                    key={startKey}
                    className={`grid grid-cols-1 gap-1 py-1 sm:grid-cols-3 sm:gap-4 ${
                        index === array.length - 1 ? '' : 'border-b-2 border-gray-100'
                    }`}
                >
                    <span className="font-semibold text-gray-800">{label}</span>
                    <span className="col-span-2 text-gray-700 break-words">
                        {startDate} s.d. {endDate}
                    </span>
                </div>
            );
        });


    return (
        <div className="space-y-8">
            <div>
                <h3 className="mb-3 text-lg font-bold text-gray-900">INFORMASI UMUM</h3>
                <div className="text-justify">{renderFields(infoUmum)}</div>
            </div>

            <div>
                <h3 className="mb-3 text-lg font-bold text-gray-900">RENCANA JADWAL KEGIATAN</h3>
                <div>{renderJadwal(jadwal)}</div>
            </div>
        </div>
    );
}