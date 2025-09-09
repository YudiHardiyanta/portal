import React, { useState } from "react";
import { Link, Head, usePage } from "@inertiajs/react";
import { Menu, X } from "lucide-react";
import FeedbackFAB from "@/Components/FeedbackFAB";

export default function AppLayout({ children, title = "Portal Satudata Bali" }) {
  const { auth } = usePage().props;
  const [isOpen, setIsOpen] = useState(false);

  return (
    <div className="flex flex-col min-h-screen bg-gray-50">
      <Head>
        <title>{title}</title>
        <link rel="icon" href="/images/logo-bali.png" type="image/png" />
      </Head>

      <nav className="sticky top-0 z-50 shadow-sm backdrop-blur-md bg-white/80">
        <div className="flex items-center justify-between px-6 py-4">
          <Link href={route("home")} className="flex items-center">
            <img
              src="/images/logo-satu-data.png"
              alt="Satu Data"
              className="w-auto h-10"
            />
          </Link>

          <ul className="hidden space-x-8 text-base font-semibold md:flex">
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
            {auth.user ? (
              <>
                <li>
                  <Link
                    href={route("logout")}
                    method="post"
                    as="button"
                    className="px-1 pb-2 text-[#1C2541] hover:text-blue-900 transition"
                  >
                    Logout
                  </Link>
                </li>
              </>
            ) : (
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
            )}
          </ul>

          <button
            className="p-2 transition md:hidden hover:bg-gray-100"
            onClick={() => setIsOpen(!isOpen)}
          >
            {isOpen ? <X size={26} /> : <Menu size={26} />}
          </button>
        </div>

        <div
          className={`md:hidden overflow-hidden transition-all duration-300 ease-in-out ${
            isOpen ? "max-h-60 opacity-100" : "max-h-0 opacity-0"
          }`}
        >
          <ul className="flex flex-col px-6 pb-4 space-y-2 text-base font-medium">
            <li>
              <Link
                href={route("home")}
                className={`block px-2 py-2 transition ${
                  route().current("home")
                    ? "text-blue-900 font-semibold"
                    : "text-gray-700 hover:text-blue-900"
                }`}
                onClick={() => setIsOpen(false)}
              >
                Beranda
              </Link>
            </li>

            {auth.user ? (
              <>
                <li>
                  <Link
                    href={route("logout")}
                    method="post"
                    as="button"
                    className="block w-full px-2 py-2 text-left text-gray-700 transition hover:text-blue-900"
                    onClick={() => setIsOpen(false)}
                  >
                    Logout
                  </Link>
                </li>
              </>
            ) : (
              <li>
                <Link
                  href={route("login")}
                  className={`block px-2 py-2 transition ${
                    route().current("login")
                      ? "text-blue-900 font-semibold"
                      : "text-gray-700 hover:text-blue-900"
                  }`}
                  onClick={() => setIsOpen(false)}
                >
                  Log in
                </Link>
              </li>
            )}
          </ul>
        </div>
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
