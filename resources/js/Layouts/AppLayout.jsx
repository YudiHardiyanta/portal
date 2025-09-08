import React from "react";
import { Link, Head } from "@inertiajs/react";
import FeedbackFAB from "@/Components/FeedbackFAB";

export default function AppLayout({ children, title = "Portal Satudata Bali" }) {
  return (
    <div className="flex flex-col min-h-screen bg-gray-50">
      <Head>
        <title>{title}</title>
        <link rel="icon" href="/images/logo-bali.png" type="image/png" />
      </Head>

      <nav className="sticky top-0 z-50 flex items-center justify-between px-6 py-4 bg-white shadow-md">
        <h1 className="flex items-center space-x-2">
          <Link href={route("home")} className="flex items-center">
            <img
              src="/images/logo-satu-data.png"
              alt="Satu Data"
              className="w-auto h-10"
            />
          </Link>
        </h1>

        <ul className="flex space-x-8 text-lg font-semibold">
          <li>
            <Link
              href={route("home")}
              className={`px-1 pb-2 transition ${
                route().current("home")
                  ? "text-blue-900 border-b-4 border-blue-900"
                  : "text-[#1C2541] hover:text-blue-900"
              }`}
            >
              Beranda
            </Link>
          </li>
          <li>
            <Link
              href={route("login")}
              className={`px-1 pb-2 transition ${
                route().current("login")
                  ? "text-blue-900 border-b-4 border-blue-900"
                  : "text-[#1C2541] hover:text-blue-900"
              }`}
            >
              Log in
            </Link>
          </li>
        </ul>
      </nav>

      <main className="flex-1">{children}</main>
      
      <footer className="py-4 text-center text-white bg-blue-900">
        <p className="text-sm">
          &copy; {new Date().getFullYear()} Portal Satudata Bali. All rights reserved.
        </p>
      </footer>

      <FeedbackFAB />
    </div>
  );
}
