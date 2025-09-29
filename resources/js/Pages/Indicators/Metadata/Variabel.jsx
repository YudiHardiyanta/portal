import { useState } from "react";

export default function MetadataVariabel({ metadata }) {
    const variabel = metadata;
    const [selected, setSelected] = useState(null);

    if (!variabel || variabel.length === 0) {
        return (
            <div>
                <h3 className="font-bold text-gray-800">Metadata Variabel</h3>
                <p className="text-gray-600">Belum ada variabel pembangun.</p>
            </div>
        );
    }

    return (
        <div>
            <h3 className="mb-3 font-bold text-gray-800">Metadata Variabel</h3>

            <ul className="mb-4 space-y-2">
                {variabel.map((v, i) => (
                    <li key={i}>
                        <button
                            onClick={() => setSelected(v)}
                            className={`w-full text-left px-3 py-2 rounded-md border transition ${
                                selected?.id === v.id
                                    ? "bg-blue-100 border-blue-400 font-semibold"
                                    : "bg-gray-50 hover:bg-gray-100 border-gray-300"
                            }`}
                        >
                            {v.nama_variabel}
                        </button>
                    </li>
                ))}
            </ul>

            {selected ? (
                <div className="p-4 space-y-2 bg-white border rounded-md shadow-sm">
                    <h4 className="text-lg font-semibold text-gray-900">
                        {selected.nama_variabel}
                    </h4>

                    {selected.alias?.length > 0 && (
                        <p className="text-sm text-gray-600">
                            <span className="font-medium">Alias:</span>{" "}
                            {Array.isArray(selected.alias)
                                ? selected.alias.join(", ")
                                : selected.alias}
                        </p>
                    )}

                    <p className="text-sm">
                        <span className="font-medium">Konsep:</span>{" "}
                        {selected.konsep ?? "-"}
                    </p>
                    <p className="text-sm">
                        <span className="font-medium">Definisi:</span>{" "}
                        {selected.definisi ?? "-"}
                    </p>
                    <p className="text-sm">
                        <span className="font-medium">Satuan:</span>{" "}
                        {selected.satuan ?? "-"}
                    </p>
                    <p className="text-sm">
                        <span className="font-medium">Tipe Data:</span>{" "}
                        {selected.tipe_data ?? "-"}
                    </p>
                    <p className="text-sm">
                        <span className="font-medium">Publik:</span>{" "}
                        {selected.is_publik ? "Ya" : "Tidak"}
                    </p>
                </div>
            ) : (
                <p className="italic text-gray-600">
                    Pilih salah satu variabel untuk melihat detail.
                </p>
            )}
        </div>
    );
}
