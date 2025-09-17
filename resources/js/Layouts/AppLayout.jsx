import React, { useState, useRef, useEffect } from "react";
import { Link, Head, usePage } from "@inertiajs/react";
import { Menu, X, User } from "lucide-react";
import FeedbackFAB from "@/Components/FeedbackFAB";

export default function AppLayout({ children, title = "Portal Satudata Bali" }) {
  const { auth } = usePage().props;
  const [isOpen, setIsOpen] = useState(false);
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);
  const dropdownRef = useRef(null);

  useEffect(() => {
    function handleClickOutside(event) {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
        setIsDropdownOpen(false);
      }
    }
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  return (
    <div className="flex flex-col min-h-screen bg-gray-50">
      <Head>
        <title>{title}</title>
        <link rel="icon" href="/images/logo-bali.png" type="image/png" />
      </Head>

      <nav className="sticky top-0 z-50 bg-white shadow-sm backdrop-blur-md">
        <div className="flex items-center justify-between px-6 py-4">
          <Link href={route("home")} className="flex items-center">
            <img
              src="/images/logo-satu-data.png"
              alt="Satu Data"
              className="w-auto h-10"
            />
          </Link>

          <ul className="items-center hidden text-base font-semibold md:flex">
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
              <li className="relative ml-6" ref={dropdownRef}>
                <button
                  onClick={(e) => {
                    e.stopPropagation();
                    setIsDropdownOpen(!isDropdownOpen);
                  }}
                  className="flex items-center justify-center w-10 h-10 text-gray-700 bg-gray-100 border border-gray-200 rounded-full hover:text-gray-900 focus:outline-none"
                >
                  <User size={24} />
                </button>

                {isDropdownOpen && (
                  <div className="absolute right-0 z-50 w-48 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <Link
                      href={route("profile.edit")}
                      className="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                    >
                      Profile
                    </Link>
                    <Link
                      href={route("logout")}
                      method="post"
                      as="button"
                      className="block w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-100"
                    >
                      Log Out
                    </Link>
                  </div>
                )}
              </li>
            ) : (
              <li className="ml-auto">
                <Link
                  href={route("login")}
                  className={`px-4 pb-2 transition ${
                    route().current("login")
                      ? "text-blue-900 border-b-4 border-blue-900"
                      : "text-[#1C2541] hover:text-blue-900"
                  }`}
                >
                  Log In
                </Link>
              </li>
            )}
          </ul>

          {/* Mobile Menu Toggle */}
          <button
            className="p-2 transition md:hidden hover:bg-gray-200"
            onClick={() => setIsOpen(!isOpen)}
          >
            {isOpen ? <X size={26} /> : <Menu size={26} />}
          </button>
        </div>

        {/* Mobile Menu */}
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
                    href={route("profile.edit")}
                    className="block px-2 py-2 text-gray-700 transition hover:text-blue-900"
                    onClick={() => setIsOpen(false)}
                  >
                    Profile
                  </Link>
                </li>
                <li>
                  <Link
                    href={route("logout")}
                    method="post"
                    as="button"
                    className="block w-full px-2 py-2 text-left text-gray-700 transition hover:text-blue-900"
                    onClick={() => setIsOpen(false)}
                  >
                    Log Out
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
                  Log In
                </Link>
              </li>
            )}
          </ul>
        </div>
      </nav>

      {/* Main Content */}
      <main className="flex-1">{children}</main>

      {/* Footer */}
      <footer className="py-4 text-center text-white bg-blue-900">
        <p className="text-sm">
          &copy; {new Date().getFullYear()} Portal Satudata Bali. All rights reserved.
        </p>
      </footer>

      <FeedbackFAB />
    </div>
  );
}
