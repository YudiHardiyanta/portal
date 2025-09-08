import React, { useState } from "react";
import { useForm } from "@inertiajs/react";

export default function FeedbackForm({ improvements, onClose }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    satisfaction: "",
    improvements: [],
    message: "",
  });

  const [localSuccess, setLocalSuccess] = useState("");
  const [visible, setVisible] = useState(true);

  const submit = (e) => {
    e.preventDefault();
    post(route("feedback.store"), {
      preserveScroll: true,
      onSuccess: () => {
        setLocalSuccess("Terima kasih sudah mengisi feedback 🙏");
        reset();
        setTimeout(() => {
          setLocalSuccess("");
          setVisible(false);
          if (onClose) onClose();
        }, 2500);
      },
    });
  };

  if (!visible) return null;

  const toggleImprovement = (id) => {
    setData(
      "improvements",
      data.improvements.includes(id)
        ? data.improvements.filter((v) => v !== id)
        : [...data.improvements, id]
    );
  };

  return (
    <form
      onSubmit={submit}
      className="w-full max-w-full p-4 mx-auto space-y-6 bg-white shadow-lg sm:max-w-lg md:max-w-xl lg:max-w-2xl sm:p-6 md:p-8 rounded-2xl"
    >
      {localSuccess && (
        <div className="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
          {localSuccess}
        </div>
      )}

      <p className="text-sm font-medium text-gray-700 sm:text-base">
        Seberapa puas Anda dengan website ini?
      </p>

      <div className="flex justify-between gap-2 sm:gap-4">
        {["😡", "😟", "😐", "😊", "😍"].map((emoji, i) => (
          <button
            type="button"
            key={i}
            className={`text-2xl sm:text-3xl rounded-full p-2 sm:p-3 transition ${
              data.satisfaction === i + 1
                ? "bg-blue-600 text-white"
                : "bg-gray-100 hover:bg-gray-200"
            }`}
            onClick={() => setData("satisfaction", i + 1)}
          >
            {emoji}
          </button>
        ))}
      </div>
      {errors.satisfaction && (
        <p className="text-sm text-red-600">{errors.satisfaction}</p>
      )}

      <div>
        <p className="mb-2 text-sm font-medium text-gray-700 sm:text-base">
          Apa yang dapat kami tingkatkan?
        </p>

        {improvements.length > 0 ? (
          <div className="flex flex-wrap gap-2">
            {improvements.map((imp) => (
              <button
                type="button"
                key={imp.id}
                onClick={() => toggleImprovement(imp.id)}
                className={`px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border text-sm sm:text-base transition ${
                  data.improvements.includes(imp.id)
                    ? "bg-blue-600 text-white border-blue-600"
                    : "bg-gray-100 text-gray-700 hover:bg-gray-200"
                }`}
              >
                {imp.name}
              </button>
            ))}
          </div>
        ) : (
          <p className="text-sm text-gray-500">Belum ada pilihan perbaikan</p>
        )}
      </div>

      <div>
        <textarea
          value={data.message}
          onChange={(e) => setData("message", e.target.value)}
          placeholder="Saran dan Masukan..."
          className="w-full p-2 text-sm border rounded-lg shadow-sm sm:p-3 focus:ring-blue-500 focus:border-blue-500 sm:text-base"
          rows={4}
        />
        {errors.message && (
          <p className="text-sm text-red-600">{errors.message}</p>
        )}
      </div>

      <button
        type="submit"
        disabled={processing || !data.satisfaction}
        className={`w-full py-2 text-sm font-medium text-white transition rounded-lg sm:py-3 sm:text-base ${
          !data.satisfaction || processing
            ? "bg-gray-400 cursor-not-allowed"
            : "bg-blue-600 hover:bg-blue-700"
        }`}
      >
        {processing ? "Mengirim..." : "Submit"}
      </button>
    </form>
  );
}
