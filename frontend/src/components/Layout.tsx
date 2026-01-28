import { Link } from 'react-router-dom';
import { Home, Wallet, Image } from 'lucide-react';

export default function Layout({ children }: { children: React.ReactNode }) {
    return (
        <div className="min-h-screen bg-dark-900 text-white font-sans">
            <nav className="fixed top-0 left-0 right-0 z-50 bg-glass backdrop-blur-glass border-b border-glass h-16 flex items-center px-6 justify-between">
                <Link to="/" className="text-xl font-bold bg-gradient-to-r from-primary-400 to-accent-purple bg-clip-text text-transparent">
                    Zdream
                </Link>
                <div className="flex items-center gap-6">
                    <Link to="/" className="flex items-center gap-2 text-white/70 hover:text-white transition-colors">
                        <Home className="w-5 h-5" />
                        <span className="hidden sm:inline">Home</span>
                    </Link>
                    <Link to="/wallet" className="flex items-center gap-2 text-white/70 hover:text-white transition-colors">
                        <Wallet className="w-5 h-5" />
                        <span className="hidden sm:inline">Wallet</span>
                    </Link>
                </div>
            </nav>
            <main className="pt-24 px-6 pb-12 max-w-7xl mx-auto">
                {children}
            </main>
        </div>
    );
}
