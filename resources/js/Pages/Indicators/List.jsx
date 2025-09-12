import { useState, useEffect } from "react";
import { router, Link } from "@inertiajs/react";
import AppLayout from "@/Layouts/AppLayout";
import { Heart, Eye, Folder, Tag } from "lucide-react";
import Skeletons from "@/Components/Skeletons";

export default function List({ indicators = [], query = "", sort = "" }) {
    const [keyword, setKeyword] = useState(query || "");
    const [localSort, setLocalSort] = useState(sort || "");
    const [localIndicators, setLocalIndicators] = useState(indicators?.data || []);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        setLocalIndicators(indicators?.data || []);
    }, [indicators]);

    const handleSearch = () => {
        setLoading(true);
        router.get(
            route("indicators.index"),
            { q: keyword, sort: localSort },
            {
                preserveState: true,
                replace: true,
                onFinish: () => setLoading(false),
            }
        );
    };

    const handleSortChange = (e) => {
        const value = e.target.value;
        setLocalSort(value);
        setLoading(true);
        router.get(
            route("indicators.index"),
            { q: keyword, sort: value },
            {
                preserveState: true,
                replace: true,
                onFinish: () => setLoading(false),
            }
        );
    };

    const handlePageClick = (url) => {
        if (!url) return;
        setLoading(true);
        router.get(url, {}, {
            preserveState: true,
            onFinish: () => setLoading(false),
        });
    };

    return (
        <AppLayout>
            <div className="flex flex-col min-h-screen px-6 py-10">
                <div className="flex-1">
                    <div className="flex flex-col items-center justify-center gap-4 mb-8 md:flex-row">
                        <div className="relative flex w-full md:w-2/3 lg:w-1/2">
                            <input
                                type="text"
                                placeholder="Cari data..."
                                value={keyword}
                                onChange={(e) => setKeyword(e.target.value)}
                                onKeyDown={(e) => e.key === "Enter" && handleSearch()}
                                disabled={loading}
                                aria-label="Pencarian indikator"
                                className="flex-1 py-2 pl-3 pr-4 text-gray-700 placeholder-gray-400 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 disabled:bg-gray-100"
                            />
                            <button
                                onClick={handleSearch}
                                disabled={loading}
                                className="px-4 py-2 text-white transition-colors bg-blue-900 rounded-r-lg hover:bg-blue-700 disabled:opacity-50"
                            >
                                {loading ? "..." : "Cari"}
                            </button>
                        </div>

                        <div className="w-full md:w-auto">
                            <select
                                value={localSort}
                                onChange={handleSortChange}
                                disabled={loading}
                                className="px-3 py-2 pr-8 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 disabled:bg-gray-100"
                            >
                                <option value="">Urutkan</option>
                                <option value="latest">Terbaru</option>
                                <option value="az">A - Z</option>
                                <option value="za">Z - A</option>
                            </select>
                        </div>
                    </div>

                    <h2 className="mb-4 text-2xl font-bold text-gray-800">
                        {query ? `Hasil pencarian '${query}'` : "Semua data indikator"}
                    </h2>

                    {loading && <Skeletons count={5} />}

                    {!loading && (
                        <>
                            {!localIndicators?.length ? (
                                <div className="flex flex-col items-center justify-center py-10 text-gray-500">
                                    <p>Tidak ada data ditemukan.</p>
                                </div>
                            ) : (
                                <div className="space-y-6">
                                    {localIndicators.map((item) => (
                                        <div
                                            key={item.slug || item.id}
                                            className="flex flex-col justify-between pb-4 border-b md:flex-row md:items-start md:space-x-4"
                                        >
                                            <div>
                                                {item.slug ? (
                                                    <Link href={route("indicators.show", { indicator: item.slug })}>
                                                        <h3 className="text-lg font-semibold text-blue-900 hover:underline">
                                                            {item.title}
                                                        </h3>
                                                    </Link>
                                                ) : (
                                                    <h3 className="text-lg font-semibold text-gray-600">{item.title}</h3>
                                                )}

                                                <div className="flex items-center mt-2 space-x-6 text-sm text-gray-500">
                                                    <span className="flex items-center space-x-1">
                                                        <Folder size={16} className="text-blue-600" />
                                                        <span>{item.kategori || "-"}</span>
                                                    </span>
                                                    <span className="flex items-center space-x-1">
                                                        <Tag size={16} className="text-green-600" />
                                                        <span>{item.subkategori || "-"}</span>
                                                    </span>
                                                </div>
                                            </div>

                                            <div className="flex items-center mt-3 space-x-4 text-gray-500 md:mt-0">
                                                <div className="flex items-center space-x-1">
                                                    <Heart size={18} />
                                                    <span className="text-sm">{item.likes_count ?? 0}</span>
                                                </div>
                                                <div className="flex items-center space-x-1">
                                                    <Eye size={18} />
                                                    <span className="text-sm">{item.total_views ?? 0}</span>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            )}

                            {indicators.links && (
                                <div className="flex justify-center mt-8 space-x-2">
                                    {indicators.links.map((link) => (
                                        <button
                                            key={link.label}
                                            onClick={() => handlePageClick(link.url)}
                                            disabled={!link.url || loading}
                                            className={`px-3 py-1 border rounded ${
                                                link.active
                                                    ? "bg-blue-900 text-white"
                                                    : "text-gray-700 hover:bg-gray-100"
                                            } disabled:opacity-50`}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ))}
                                </div>
                            )}
                        </>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
