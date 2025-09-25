import { useState } from "react";
import { router, usePage } from "@inertiajs/react";
import AppLayout from "@/Layouts/AppLayout";
import { Eye, Heart, Folder, Tag, StickyNote, AlertCircle } from "lucide-react";

import MetadataIndikator from "./Metadata/Indikator";
import MetadataVariabel from "./Metadata/Variabel";
import MetadataKegiatan from "./Metadata/Kegiatan";

export default function Show({ indicator, token }) {
    const { auth } = usePage().props;
    const [activeTab, setActiveTab] = useState("data");
    const [activeSubTab, setActiveSubTab] = useState("indikator");
    const [liked, setLiked] = useState(indicator.is_liked ?? false);
    const [likesCount, setLikesCount] = useState(indicator.likes ?? 0);

    const iframeUrl =
        "https://metabase.statsbali.id/embed/dashboard/" +
        token +
        "#bordered=true&titled=true";

    const handleLike = () => {
        if (!auth.user) {
            router.visit(route("login"));
            return;
        }

        const likeRoute = route(
            liked ? "indicators.unlike" : "indicators.like",
            { indicator: indicator.slug }
        );

        router.post(likeRoute, {}, {
            preserveScroll: true,
            onSuccess: () => {
                setLiked(!liked);
                setLikesCount(prev => liked ? prev - 1 : prev + 1);
            }
        });
    };

    return (
        <AppLayout title={indicator.title}>
            <main className="flex-grow bg-white">
                <div className="relative mb-12 text-white shadow-md rounded-b-2xl bg-gradient-to-r from-blue-900 via-blue-800 to-blue-600">
                    <div className="relative z-10 max-w-6xl px-6 py-12 mx-auto">
                        <h2 className="text-3xl font-bold leading-snug md:text-4xl lg:text-5xl drop-shadow-md">
                            {indicator.title}
                        </h2>

                        <div className="flex flex-wrap gap-4 mt-6 text-sm text-blue-100">
                            <span className="flex items-center gap-1">
                                <Folder size={16} /> {indicator.kategori ?? "-"}
                            </span>
                            <span className="flex items-center gap-1">
                                <Tag size={16} /> {indicator.subkategori ?? "-"}
                            </span>
                            {indicator.unit && (
                                <span className="px-3 py-1 text-xs rounded-full bg-white/20 backdrop-blur-sm">
                                    Unit : {indicator.unit}
                                </span>
                            )}
                        </div>

                        <div className="flex gap-6 mt-6 text-sm text-blue-100">
                            <span className="flex items-center gap-1">
                                <Eye size={18} /> {indicator.views}
                            </span>
                            <button
                                onClick={handleLike}
                                className="flex items-center gap-1 focus:outline-none"
                            >
                                <Heart
                                    size={18}
                                    className={liked ? "text-red-500 fill-red-500" : "text-blue-100"}
                                />
                                {likesCount}
                            </button>
                        </div>

                        {indicator.notes && (
                            <div className="flex items-start gap-2 p-4 mt-4 text-sm bg-white/10 backdrop-blur-sm rounded-xl">
                                <StickyNote size={18} className="mt-0.5" />
                                <span>{indicator.notes}</span>
                            </div>
                        )}

                        {indicator.def && (
                            <p className="mt-4 text-base md:text-lg opacity-90 text-blue-50">
                                {indicator.def}
                            </p>
                        )}
                    </div>
                </div>

                <div className="px-6">
                    <div className="mx-auto mt-6 bg-white border shadow-lg rounded-2xl">
                        <div className="flex border-b">
                            {["data", "metadata", "standar"].map(tab => (
                                <button
                                    key={tab}
                                    onClick={() => setActiveTab(tab)}
                                    className={`flex-1 px-4 py-2 text-center ${
                                        activeTab === tab
                                            ? "border-b-2 border-blue-600 text-blue-600 font-semibold"
                                            : "text-gray-600 hover:text-blue-600"
                                    }`}
                                >
                                    {tab === "data" ? "Data" : tab === "metadata" ? "Metadata" : "Standar Data"}
                                </button>
                            ))}
                        </div>
                        <div className="p-4">
                            {activeTab === "data" && (
                                indicator.id_dashboard ? (
                                    <iframe
                                        src={iframeUrl}
                                        width="100%"
                                        height="600"
                                        allowTransparency
                                    ></iframe>
                                ) : (
                                    <div className="flex items-center justify-center gap-2 p-6 text-gray-500">
                                        <AlertCircle size={20} className="text-gray-400" />
                                        <span>Data saat ini tidak tersedia</span>
                                    </div>
                                )
                            )}

                            {activeTab === "metadata" && (
                                <div className="flex">
                                    <div className="w-1/4 border-r bg-gray-50/50">
                                        {["indikator", "variabel", "kegiatan"].map(sub => (
                                            <button
                                                key={sub}
                                                onClick={() => setActiveSubTab(sub)}
                                                className={`block w-full px-4 py-3 text-left transition-colors duration-150 ${
                                                    activeSubTab === sub
                                                        ? "bg-blue-50 text-blue-700 font-semibold border-r-2 border-blue-600"
                                                        : "text-gray-700 hover:bg-gray-100"
                                                }`}
                                            >
                                                {sub === "indikator"
                                                    ? "Metadata Indikator"
                                                    : sub === "variabel"
                                                        ? "Metadata Variabel"
                                                        : "Metadata Kegiatan"}
                                            </button>
                                        ))}
                                    </div>

                                    <div className="flex-1 p-6">
                                        {activeSubTab === "indikator" && (
                                            <MetadataIndikator metadata={indicator.metadata} />
                                        )}
                                        {activeSubTab === "variabel" && (
                                            <MetadataVariabel metadata={indicator.metadata_variabel} />
                                        )}
                                        {activeSubTab === "kegiatan" && (
                                            <MetadataKegiatan metadata={indicator.metadata_kegiatan} />
                                        )}
                                    </div>
                                </div>
                            )}

                            {activeTab === "standar" && (
                                <div>
                                    <h2 className="mb-2 text-lg font-bold">Standar Data</h2>
                                    <p className="text-gray-700">Penjelasan Standar Data ditampilkan di sini.</p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </main>
        </AppLayout>
    );
}
