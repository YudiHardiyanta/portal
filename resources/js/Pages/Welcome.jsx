import { useState } from "react";
import AppLayout from "@/Layouts/AppLayout";
import { router, Link } from "@inertiajs/react";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/pagination";
import { Pagination } from "swiper/modules";

export default function Welcome({ auth, laravelVersion, phpVersion, token, latestIndicators = [] }) {
  const [keyword, setKeyword] = useState("");

  const handleSearch = () => {
    if (keyword.trim() !== "") {
      router.get(route("indicators.index"), { q: keyword });
    } else {
      router.get(route("indicators.index"));
    }
  };

  const iframeUrl =
    "https://metabase.statsbali.id/embed/dashboard/" +
    token +
    "#bordered=true&titled=true";

  return (
    <AppLayout title="Beranda">
      {/* Hero Section */}
      <section className="relative flex flex-col items-center justify-center py-24 text-white bg-blue-900">
        <img
          src="https://picsum.photos/1600/900?grayscale"
          alt="Jumbotron Image"
          className="absolute inset-0 object-cover w-full h-full opacity-40"
        />
        <div className="relative z-10 max-w-2xl text-center">
          <h2 className="mb-4 text-4xl font-bold md:text-5xl">
            Selamat Datang
          </h2>
          <p className="mb-8 text-lg md:text-xl">
            Cari informasi atau data yang kamu butuhkan di sini
          </p>
          <form
            onSubmit={(e) => {
              e.preventDefault();
              handleSearch();
            }}
            className="flex justify-center max-w-md mx-auto"
          >
            <input
              type="text"
              placeholder="Cari dataset..."
              value={keyword}
              onChange={(e) => setKeyword(e.target.value)}
              className="w-full px-4 py-2 text-gray-900 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            />
            <button
              type="submit"
              className="px-6 py-2 font-semibold text-white transition bg-blue-700 rounded-r-lg hover:bg-blue-600"
            >
              Cari
            </button>
          </form>
        </div>
      </section>

      {/* Dataset Terbaru */}
      <main className="flex-grow px-6 py-16 bg-gray-50">
        <h3 className="mb-10 text-2xl font-bold text-center text-blue-900">
          📊 Dataset Terbaru
        </h3>

        <Swiper
          modules={[Pagination]}
          spaceBetween={24}
          slidesPerView={3}
          pagination={{ clickable: true }}
          breakpoints={{
            320: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
          }}
        >
          {latestIndicators.length > 0 ? (
            latestIndicators.map((item) => (
              <SwiperSlide key={item.id}>
                <div className="relative z-0 flex flex-col justify-between h-56 p-6 transition border border-gray-200 shadow-sm rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 hover:shadow-lg hover:-translate-y-1">
                  <div>
                    <span className="px-3 py-1 text-xs font-semibold text-white bg-blue-900 rounded-full">
                      Dataset
                    </span>
                    <h2 className="mt-4 text-lg font-semibold text-gray-800 break-words line-clamp-3">
                      {item.title}
                    </h2>
                  </div>
                  <Link
                    href={route("indicators.show", { indicator: item.slug })}
                    className="mt-4 text-sm font-medium text-blue-700 hover:underline"
                  >
                    Lihat Detail →
                  </Link>
                </div>
              </SwiperSlide>
            ))
          ) : (
            <p className="text-center text-gray-500">Belum ada dataset terbaru.</p>
          )}
        </Swiper>
      </main>
    </AppLayout>
  );
}