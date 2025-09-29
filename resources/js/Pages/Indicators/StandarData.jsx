export default function StandarData({ standar_data }) {
    if (!standar_data) {
        return <div className="text-gray-500">Standar data belum tersedia</div>;
    }

    return (
        <div className="p-2">
            <h3 className="font-bold">{standar_data.nama_data}</h3>
            <p>{standar_data.definisi}</p>
            
            {standar_data.konsep && standar_data.konsep.length > 0 && (
                <ul className="mt-4 text-sm list-disc list-inside">
                    {standar_data.konsep.map(k => (
                        <li  className="mt-1" key={k.id}>
                            <strong>{k.kode}</strong> - {k.konsep}
                            <p className="text-gray-600">{k.definisi}</p>
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
}
