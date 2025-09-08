import { Dialog, DialogPanel, DialogTitle } from "@headlessui/react";
import { X, MessageCircle } from "lucide-react";
import { useState } from "react";
import FeedbackForm from "../Pages/FeedbackForm";

export default function FeedbackFAB() {
  const [isOpen, setIsOpen] = useState(false);
  const [improvements, setImprovements] = useState(null);
  const [loading, setLoading] = useState(false);

  const openModal = () => {
    setLoading(true);
    fetch("/api/improvements") 
      .then((res) => res.json())
      .then((data) => {
        setImprovements(data);
        setLoading(false);
        setIsOpen(true);
      })
      .catch(() => setLoading(false));
  };

  return (
    <>
      <button
        onClick={openModal}
        className="fixed flex items-center justify-center text-white transition bg-blue-600 rounded-full shadow-lg bottom-6 right-6 w-14 h-14 hover:bg-blue-700"
      >
        <MessageCircle className="w-7 h-7" />
      </button>

      {isOpen && improvements && (
        <Dialog
          open={isOpen}
          onClose={() => setIsOpen(false)}
          className="relative z-50"
        >
          <div className="fixed inset-0 bg-black/40" aria-hidden="true" />
          <div className="fixed inset-0 flex items-center justify-center p-4">
            <DialogPanel className="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-xl">
              <button
                onClick={() => setIsOpen(false)}
                className="absolute text-gray-500 top-3 right-3 hover:text-gray-700"
              >
                <X className="w-5 h-5" />
              </button>

              <DialogTitle className="mb-4 text-xl font-semibold text-gray-900">
                Feedback
              </DialogTitle>

              <FeedbackForm
                improvements={improvements}
                onClose={() => setIsOpen(false)}
              />
            </DialogPanel>
          </div>
        </Dialog>
      )}
    </>
  );
}
