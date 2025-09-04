import { useState } from "react";
import AppLayout from '@/Layouts/AppLayout';
import { router } from '@inertiajs/react';

export default function Welcome({ auth, laravelVersion, phpVersion, token }) {
    const handleImageError = () => {
        document
            .getElementById('screenshot-container')
            ?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document
            .getElementById('docs-card-content')
            ?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };

    //untuk tab data, metadata dan standar data
    const [activeTab, setActiveTab] = useState("data");
    const [keyword, setKeyword] = useState("");

    const handleSearch = () => {
        if (keyword.trim() !== "") {
            router.get(route("indicators.index"), { q: keyword }, {
                preserveState: false,
                replace: false,
            });
        } else {
            router.get(route("indicators.index"), {}, {
                preserveState: false,
                replace: false,
            });
        }
    };

    //sampel untuk akses ke metabase
    var iframeUrl = "https://metabase.statsbali.id" + "/embed/dashboard/" + token +
        "#bordered=true&titled=true";

    return (
        <AppLayout title="Beranda">
            <section class="relative bg-blue-800 text-white flex flex-col items-center justify-center py-20">
                <img src="https://picsum.photos/1200/800?grayscale"
                    alt="Jumbotron Image"
                    class="absolute inset-0 w-full h-full object-cover opacity-50"></img>
                <div class="relative z-10 text-center">
                    <h2 class="text-4xl font-bold mb-4">Selamat Datang</h2>
                    <p class="mb-6">Cari informasi atau data yang kamu butuhkan di sini</p>
                    <div className="flex justify-center">
                        <input
                            type="text"
                            placeholder="Cari sesuatu..."
                            value={keyword}
                            onChange={(e) => setKeyword(e.target.value)}
                            className="w-64 px-4 py-2 text-black rounded-l-lg focus:outline-none"
                        />
                        <button
                            onClick={handleSearch}
                            className="px-4 py-2 bg-blue-900 rounded-r-lg hover:bg-blue-700"
                        >
                            Cari
                        </button>
                    </div>
                </div>
            </section>
            
            <main class="flex-grow bg-white px-6 py-10">
                <h3 class="text-2xl font-semibold mb-4">Konten Utama</h3>
                <p class="text-gray-700 leading-relaxed">

                    {/* Card Highligh Indikator Component */}
                    <div class="bg-white shadow-lg rounded-2xl p-6 w-64">
                        <h2 class="text-lg font-semibold text-gray-700">Indikator A</h2>
                        <p class="text-2xl font-bold text-gray-900 mt-2">Rp 5.200</p>
                        <div class="flex items-center mt-3">
                            <span class="text-green-600 flex items-center font-medium">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                +3.2%
                            </span>
                        </div>
                    </div>

                    {/* Component data dan standar data */}
                    <div className="mx-auto mt-10 bg-white border shadow-lg rounded-2xl">
                        {/* Header Tab */}
                        <div className="flex border-b">
                            <button
                                onClick={() => setActiveTab("data")}
                                className={`flex-1 px-4 py-2 text-center ${activeTab === "data"
                                    ? "border-b-2 border-blue-600 text-blue-600 font-semibold"
                                    : "text-gray-600 hover:text-blue-600"
                                    }`}
                            >
                                Data
                            </button>
                            <button
                                onClick={() => setActiveTab("metadata")}
                                className={`flex-1 px-4 py-2 text-center ${activeTab === "metadata"
                                    ? "border-b-2 border-blue-600 text-blue-600 font-semibold"
                                    : "text-gray-600 hover:text-blue-600"
                                    }`}
                            >
                                Metadata
                            </button>
                            <button
                                onClick={() => setActiveTab("standar")}
                                className={`flex-1 px-4 py-2 text-center ${activeTab === "standar"
                                    ? "border-b-2 border-blue-600 text-blue-600 font-semibold"
                                    : "text-gray-600 hover:text-blue-600"
                                    }`}
                            >
                                Standar Data
                            </button>
                        </div>

                        {/* Content */}
                        <div className="p-4">
                            {activeTab === "data" && (
                                <div>
                                    
                                    <iframe
                                        src={iframeUrl}
                                        frameborder="0"
                                        width="100%"
                                        height="600"
                                        allowtransparency
                                    ></iframe>
                                </div>
                            )}

                            {activeTab === "metadata" && (
                                <div>
                                    <h2 className="mb-2 text-lg font-bold">Metadata</h2>
                                    <p className="text-gray-700">
                                        Informasi Metadata ditampilkan di sini.
                                    </p>
                                </div>
                            )}

                            {activeTab === "standar" && (
                                <div>
                                    <h2 className="mb-2 text-lg font-bold">Standar Data</h2>
                                    <p className="text-gray-700">
                                        Penjelasan Standar Data ditampilkan di sini.
                                    </p>
                                </div>
                            )}
                        </div>
                    </div>


                </p>
            </main>
        </AppLayout>
    );
}