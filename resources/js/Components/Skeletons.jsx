export default function Skeletons() {
    return (
        <div className="space-y-6 animate-pulse">
            {[...Array(5)].map((_, i) => (
                <div key={i} className="flex items-start space-x-4">
                    <div className="w-16 h-16 bg-gray-300 rounded"></div>
                    
                    <div className="flex-1 space-y-3">
                        <div className="w-3/4 h-4 bg-gray-300 rounded"></div>
                        <div className="w-1/2 h-4 bg-gray-300 rounded"></div>
                        <div className="w-1/3 h-3 bg-gray-200 rounded"></div>
                    </div>
                </div>
            ))}
        </div>
    );
}
