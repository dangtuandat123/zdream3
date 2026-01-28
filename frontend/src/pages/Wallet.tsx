import { useEffect, useState } from 'react';
import { getBalance, getHistory } from '../services/api';
import { Card, CardHeader, CardTitle, CardContent } from '../components/ui/Card';

export default function Wallet() {
    const [balance, setBalance] = useState(0);
    const [history, setHistory] = useState<any[]>([]);

    useEffect(() => {
        getBalance().then(res => setBalance(res.data.credits));
        getHistory().then(res => setHistory(res.data.data)); // Pagination data
    }, []);

    return (
        <div className="max-w-2xl mx-auto">
            <Card className="mb-8 bg-gradient-to-br from-primary-900/50 to-dark-800">
                <CardHeader>
                    <CardTitle>Your Balance</CardTitle>
                </CardHeader>
                <CardContent>
                    <div className="text-4xl font-bold text-primary-400">{balance} Credits</div>
                </CardContent>
            </Card>

            <h2 className="text-xl font-bold mb-4">History</h2>
            <div className="space-y-4">
                {history.map(item => (
                    <Card key={item.id} variant="outline" className="p-4 flex items-center gap-4">
                        <div className="w-16 h-16 bg-dark-800 rounded-md overflow-hidden flex-shrink-0">
                            {item.storage_path && <img src={`/storage/${item.storage_path}`} className="w-full h-full object-cover" />}
                        </div>
                        <div>
                            <div className="font-medium">{item.style?.name || 'Unknown Style'}</div>
                            <div className="text-sm text-white/60">{item.created_at}</div>
                        </div>
                        <div className="ml-auto">
                            <span className={`px-2 py-1 rounded text-xs ${item.status === 'completed' ? 'bg-green-500/20 text-green-400' :
                                    item.status === 'failed' ? 'bg-red-500/20 text-red-400' :
                                        'bg-yellow-500/20 text-yellow-400'
                                }`}>
                                {item.status}
                            </span>
                        </div>
                    </Card>
                ))}
            </div>
        </div>
    );
}
