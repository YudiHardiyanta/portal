import { useForm } from "@inertiajs/react";
import { Combobox, ComboboxOption, ComboboxOptions, ComboboxButton } from "@headlessui/react";
import { Check, ChevronDown } from "lucide-react";

export default function FeedbackForm({ onSubmitted }) {
  const { data, setData, post, processing, errors } = useForm({
    satisfaction: "",
    job: "",
    improvements: [],
    message: "",
  });

  const jobs = ["Pelajar", "PNS", "Wiraswasta"];
  const improvementsList = [
    "Tampilan",
    "Pencarian Data",
    "Kelengkapan Data",
    "Metadata",
    "Fitur",
    "Performa Akses",
  ];

  const toggleImprovement = (value) => {
    if (data.improvements.includes(value)) {
      setData(
        "improvements",
        data.improvements.filter((v) => v !== value)
      );
    } else {
      setData("improvements", [...data.improvements, value]);
    }
  };

  const submit = (e) => {
    e.preventDefault();
    post(route("feedback.store"), {
      onSuccess: () => {
        if (onSubmitted) onSubmitted();
      },
    });
  };

  return (
    <form
      onSubmit={submit}
      className="w-full max-w-full p-4 mx-auto space-y-6 bg-white shadow-lg sm:max-w-lg md:max-w-xl lg:max-w-2xl sm:p-6 md:p-8 rounded-2xl"
    >
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

      <div>
        <Combobox value={data.job} onChange={(value) => setData("job", value)}>
          <div className="relative">
            <ComboboxButton className="relative w-full py-2 pl-3 pr-10 text-left bg-white border rounded-lg shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
              <span className="block truncate">
                {data.job || "Pilih Pekerjaan"}
              </span>
              <span className="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <ChevronDown className="w-5 h-5 text-gray-400" />
              </span>
            </ComboboxButton>

            <ComboboxOptions className="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-lg shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
              {jobs.map((job, idx) => (
                <ComboboxOption
                  key={idx}
                  value={job}
                  className={({ active }) =>
                    `relative cursor-pointer select-none py-2 pl-10 pr-4 ${
                      active ? "bg-blue-100 text-blue-900" : "text-gray-900"
                    }`
                  }
                >
                  {({ selected }) => (
                    <>
                      <span
                        className={`block truncate ${
                          selected ? "font-medium" : "font-normal"
                        }`}
                      >
                        {job}
                      </span>
                      {selected && (
                        <span className="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600">
                          <Check className="w-5 h-5" />
                        </span>
                      )}
                    </>
                  )}
                </ComboboxOption>
              ))}
            </ComboboxOptions>
          </div>
        </Combobox>
        {errors.job && <p className="text-sm text-red-600">{errors.job}</p>}
      </div>

      <div>
        <p className="mb-2 text-sm font-medium text-gray-700 sm:text-base">
          Apa yang dapat kami tingkatkan?
        </p>
        <div className="flex flex-wrap gap-2">
          {improvementsList.map((imp) => (
            <button
              type="button"
              key={imp}
              onClick={() => toggleImprovement(imp)}
              className={`px-3 sm:px-4 py-1.5 sm:py-2 rounded-full border text-sm sm:text-base transition ${
                data.improvements.includes(imp)
                  ? "bg-blue-600 text-white border-blue-600"
                  : "bg-gray-100 text-gray-700 hover:bg-gray-200"
              }`}
            >
              {imp}
            </button>
          ))}
        </div>
      </div>

      {/* Saran */}
      <div>
        <textarea
          value={data.message}
          onChange={(e) => setData("message", e.target.value)}
          placeholder="Saran dan Masukkan..."
          className="w-full p-2 text-sm border rounded-lg shadow-sm sm:p-3 focus:ring-blue-500 focus:border-blue-500 sm:text-base"
          rows={4}
        />
        {errors.message && (
          <p className="text-sm text-red-600">{errors.message}</p>
        )}
      </div>

      {/* Submit */}
      <button
        type="submit"
        disabled={processing}
        className="w-full py-2 text-sm font-medium text-white transition bg-blue-600 rounded-lg sm:py-3 hover:bg-blue-700 disabled:opacity-50 sm:text-base"
      >
        {processing ? "Mengirim..." : "Submit"}
      </button>
    </form>
  );
}
