import React from "react";
import { Link, Head } from "@inertiajs/react";
import FeedbackFAB from "@/Components/FeedbackFAB";

export default function AppLayout({ children, title = "Portal Satudata Bali" }) {
  return (
    <div className="flex flex-col min-h-screen">
      {/* Head */}
      <Head title={title} />

      {/* Navbar */}
      <nav className="sticky top-0 z-50 flex items-center justify-between px-6 py-4 text-white bg-blue-900">
        <h1 className="text-xl font-bold">{title}</h1>
        <ul className="flex space-x-6">
          <li>
            <Link href="#" className="hover:text-gray-300">
              Beranda
            </Link>
          </li>
          <li>
            <Link href={route("login")} className="hover:text-gray-300">
              Log in
            </Link>
          </li>
        </ul>
      </nav>

      {/* Konten utama */}
      <main className="flex-1">{children}</main>

      {/* Footer */}
      <footer className="py-4 text-center text-white bg-blue-900">
        <p>&copy; {new Date().getFullYear()} Portal Satudata Bali.</p>
      </footer>

      {/* Feedback Floating Action Button */}
      <FeedbackFAB/>
    </div>
  );
}