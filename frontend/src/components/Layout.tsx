import Sidebar from "./Sidebar";

export default function Layout() {
    return (
        <div className="bg-[#0f1724] text-slate-200 h-screen">
            <div className="flex flex-1">
                <aside className="w-72 bg-[#0b1520] p-4 hidden md:block">
                    <Sidebar />
                </aside>
            </div>
        </div>
    );
}