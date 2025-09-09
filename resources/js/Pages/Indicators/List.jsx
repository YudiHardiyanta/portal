import { useState, useEffect } from "react";
import { router, usePage, Link } from "@inertiajs/react";
import AppLayout from "@/Layouts/AppLayout";
import { Heart, Eye, Folder, Tag } from "lucide-react";
import Skeletons from "@/Components/Skeletons";

export default function List({ indicators = [], query = "", sort = "" }) {
    const { auth } = usePage().props;
    const [keyword, setKeyword] = useState(query || "");
    const [localSort, setLocalSort] = useState(sort || "");
    const [localIndicators, setLocalIndicators] = useState(indicators.data || []);
    const [loading, setLoading] = useState(false);
    const [skipEffect, setSkipEffect] = useState(false);

    useEffect(() => {
        setLocalIndicators(indicators.data || []);
    }, [indicators]);

    useEffect(() => {
        if (skipEffect) {
            setSkipEffect(false);
            return;
        }

        const delay = setTimeout(() => {
            if (keyword !== query || localSort !== sort) {
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
            }
        }, 600);

        return () => clearTimeout(delay);
    }, [keyword, localSort]);

    const handleSortChange = (e) => {
        const value = e.target.value;
        setLocalSort(value);
        router.get(route("indicators.index"), { q: keyword, sort: value }, {
            preserveState: true,
            replace: true,
        });
    };

    const toggleLike = (indicator) => {
        if (!auth.user) {
            router.visit(route("login"));
            return;
        }

        const updatedIndicators = localIndicators.map((item) =>
            item.var_id === indicator.var_id
                ? {
                      ...item,
                      liked: !item.liked,
                      likes_count: item.liked
                          ? item.likes_count - 1
                          : item.likes_count + 1,
                  }
                : item
        );
        setLocalIndicators(updatedIndicators);

        if (indicator.liked) {
            router.delete(route("indicators.unlike", indicator.var_id), {
                preserveScroll: true,
                preserveState: true,
            });
        } else {
            router.post(route("indicators.like", indicator.var_id), {}, {
                preserveScroll: true,
                preserveState: true,
            });
        }
    };

    const handlePageClick = (url) => {
        if (!url) return;
        setSkipEffect(true); 
        router.get(url, {}, { preserveState: true });
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
                                onKeyDown={(e) => {
                                    if (e.key === "Enter") {
                                        router.get(route("indicators.index"), {
                                            q: keyword,
                                            sort: localSort,
                                        });
                                    }
                                }}
                                className="flex-1 py-2 pl-3 pr-4 text-gray-700 placeholder-gray-400 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                            <button
                                onClick={() =>
                                    router.get(route("indicators.index"), {
                                        q: keyword,
                                        sort: localSort,
                                    })
                                }
                                className="px-4 py-2 text-white transition-colors bg-blue-900 rounded-r-lg hover:bg-blue-700"
                            >
                                Cari
                            </button>
                        </div>

                        <div className="w-full md:w-auto">
                            <select
                                value={localSort}
                                onChange={handleSortChange}
                                className="px-3 py-2 pr-8 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">Urutkan</option>
                                <option value="latest">Terbaru</option>
                                <option value="az">A - Z</option>
                                <option value="za">Z - A</option>
                            </select>
                        </div>
                    </div>

                    <h2 className="mb-4 text-2xl font-bold">
                        {query ? `Hasil pencarian '${query}'` : "Semua data indikator"}
                    </h2>

                    {loading && <Skeletons count={5} />}
                    {!loading && (
                        <>
                            {(!localIndicators || localIndicators.length === 0) ? (
                                <div className="flex flex-col items-center justify-center py-10 text-gray-500">
                                    <p>Tidak ada data ditemukan.</p>
                                </div>
                            ) : (
                                <div className="space-y-6">
                                    {localIndicators.map((item) => (
                                        <div
                                            key={item.var_id}
                                            className="flex items-start justify-between pb-4 space-x-4 border-b"
                                        >
                                            <div>
                                                <Link href={route("indicators.show", { indicator: item.var_id })}>
                                                    <h3 className="text-lg font-semibold">{item.title}</h3>
                                                </Link>

                                                <p className="text-gray-600">{item.location}</p>

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

                                            <div className="flex items-center space-x-4 text-gray-500">
                                                <button
                                                    onClick={() => toggleLike(item)}
                                                    className="flex items-center space-x-1"
                                                >
                                                    <Heart
                                                        size={18}
                                                        className={item.liked ? "text-red-500" : "text-gray-400"}
                                                    />
                                                    <span className="text-sm">{item.likes_count}</span>
                                                </button>
                                                <div className="flex items-center space-x-1">
                                                    <Eye size={18} />
                                                    <span className="text-sm">{item.total_views}</span>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </>
                    )}
                </div>

                {indicators.links && (
                <div className="flex justify-center mt-8 space-x-2">
                    {indicators.links.map((link, index) => (
                    <button
                        key={index}
                        onClick={() => handlePageClick(link.url)}
                        disabled={!link.url}
                        className={`px-3 py-1 border rounded ${
                        link.active ? "bg-blue-900 text-white" : "text-gray-700"
                        }`}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                    />
                    ))}
                </div>
                )}
            </div>
        </AppLayout>
    );
}
