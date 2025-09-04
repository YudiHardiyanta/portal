import { useState } from "react";
import { router, usePage } from "@inertiajs/react";
import AppLayout from "@/Layouts/AppLayout";
import { Heart, Eye } from "lucide-react";
import Skeletons from "@/Components/Skeletons";

export default function Index({ indicators = [], query = "" }) {
    const { auth } = usePage().props;
    const [keyword, setKeyword] = useState(query || "");
    const [loading, setLoading] = useState(false);

    const handleSearch = () => {
        setLoading(true);

        if (!keyword.trim()) {
            router.get(route("indicators.index"), {}, {
                preserveState: true,
                replace: true,
                onFinish: () => setLoading(false),
            });
        } else {
            router.get(route("indicators.index"), { q: keyword }, {
                preserveState: true,
                replace: true,
                onFinish: () => setLoading(false),
            });
        }
    };

    const toggleLike = (indicator) => {
        if (!auth.user) {
            router.visit(route("login"));
            return;
        }

        if (indicator.liked) {
            router.delete(route("indicators.unlike", indicator.id), {
                preserveScroll: true,
            });
        } else {
            router.post(route("indicators.like", indicator.id), {}, {
                preserveScroll: true,
            });
        }
    };

    return (
        <AppLayout>
            <div className="px-6 py-10">
                <div className="flex justify-center mb-8">
                    <input
                        type="text"
                        placeholder="Cari data..."
                        value={keyword}
                        onChange={(e) => setKeyword(e.target.value)}
                        className="px-4 py-2 border border-gray-300 rounded-l-lg w-96 focus:outline-none"
                    />
                    <button
                        onClick={handleSearch}
                        className="px-4 py-2 text-white bg-blue-900 rounded-r-lg hover:bg-blue-700"
                    >
                        Cari
                    </button>
                </div>
                <h2 className="mb-4 text-2xl font-bold">
                    {query
                        ? `Hasil pencarian '${query}'`
                        : "Semua data indikator"}
                </h2>

                {loading && <Skeletons count={5} />}
                {!loading && (
                    <>
                        {(!indicators || indicators.length === 0) ? (
                            <p className="text-gray-500">Tidak ada data ditemukan.</p>
                        ) : (
                            <div className="space-y-6">
                                {indicators.map((item) => (
                                    <div
                                        key={item.id}
                                        className="flex items-start justify-between pb-4 space-x-4 border-b"
                                    >
                                        <div>
                                            <a href={route("indicators.show", item.id)}>
                                                <h3 className="text-lg font-semibold">
                                                    {item.name}
                                                </h3>
                                            </a>
                                            <p className="text-gray-600">{item.description}</p>
                                            <div className="flex items-center mt-2 space-x-4 text-sm text-gray-500">
                                                <span>📍 {item.location}</span>
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
        </AppLayout>
    );
}
