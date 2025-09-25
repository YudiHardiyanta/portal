export default function MetadataIndikator({ metadata }) {
    return (
        <div className="space-y-3">
            <h3 className="font-bold text-gray-800">Metadata Indikator</h3>
            <div className="flex flex-col gap-3 text-gray-700">
                <div>
                    <span className="font-semibold">Nama Indikator:</span>{" "}
                    {metadata?.nama_indikator ?? "-"}
                </div>
                <div>
                    <span className="font-semibold">Konsep:</span>{" "}
                    {metadata?.konsep ?? "-"}
                </div>
                <div>
                    <span className="font-semibold">Definisi:</span>{" "}
                    {metadata?.definisi ?? "-"}
                </div>
                <div>
                    <span className="font-semibold">Interpretasi:</span>{" "}
                    {metadata?.interpretasi ?? "-"}
                </div>
                <div>
                    <span className="font-semibold">Metode Perhitungan:</span>{" "}
                    {metadata?.metode_perhitungan ?? "-"}
                </div>
                <div>
                    <span className="font-semibold">Rumus:</span>{" "}
                    {metadata?.rumus ?? "-"}
                </div>
                <div>
                    <span className="font-semibold">Ukuran:</span>{" "}
                    {metadata?.ukuran ?? "-"}
                </div>
                <div>
                    <span className="font-semibold">Satuan:</span>{" "}
                    {metadata?.satuan ?? "-"}
                </div>
                <div>
                    <span className="font-semibold">Variabel Disagregasi:</span>{" "}
                    {metadata?.variabel_disagregasi
                        ? metadata.variabel_disagregasi.join(", ")
                        : "-"}
                </div>
                <div>
                    <span className="font-semibold">Variabel Pembangun:</span>{" "}
                    {metadata?.variabel_pembangun?.length > 0 ? (
                        <ul className="space-y-1 list-disc list-inside">
                            {metadata.variabel_pembangun.map((v, i) => (
                                <li key={i}>{v.nama_variabel}</li>
                            ))}
                        </ul>
                    ) : (
                        "-"
                    )}
                </div>
            </div>
        </div>
    );
}
