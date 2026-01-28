import { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { getStyle, generateImage, pollImage } from '../services/api';
import { Button } from '../components/ui/Button';
import { Input } from '../components/ui/Input';
import { Card } from '../components/ui/Card';

export default function Studio() {
    const { id } = useParams();
    const [style, setStyle] = useState<any>(null);
    const [prompt, setPrompt] = useState('');
    const [loading, setLoading] = useState(false);
    const [result, setResult] = useState<any>(null);
    const [error, setError] = useState('');

    useEffect(() => {
        if (id) {
            getStyle(Number(id)).then(res => setStyle(res.data));
        }
    }, [id]);

    const handleGenerate = async () => {
        setLoading(true);
        setError('');
        setResult(null);
        try {
            const res = await generateImage({
                style_id: style.id,
                prompt,
                // Add options here
            });
            const taskId = res.data.id;
            poll(taskId);
        } catch (err: any) {
            setError(err.response?.data?.message || 'Generation failed');
            setLoading(false);
        }
    };

    const poll = (taskId: number) => {
        const interval = setInterval(async () => {
            try {
                const res = await pollImage(taskId);
                if (res.data.status === 'completed') {
                    clearInterval(interval);
                    setResult(res.data);
                    setLoading(false);
                } else if (res.data.status === 'failed') {
                    clearInterval(interval);
                    setError(res.data.error_message || 'Generation failed');
                    setLoading(false);
                }
            } catch (err) {
                clearInterval(interval);
                setLoading(false);
            }
        }, 2000);
    };

    if (!style) return <div>Loading...</div>;

    return (
        <div className="max-w-4xl mx-auto">
            <h1 className="text-2xl font-bold mb-6">{style.name} Studio</h1>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div className="space-y-6">
                    <Card>
                        <div className="space-y-4">
                            <div>
                                <label className="block text-sm font-medium mb-2 text-white/80">Prompt</label>
                                <Input
                                    value={prompt}
                                    onChange={e => setPrompt(e.target.value)}
                                    placeholder="Describe your image..."
                                />
                            </div>
                            <Button
                                onClick={handleGenerate}
                                isLoading={loading}
                                className="w-full"
                            >
                                Generate ({style.price} Credits)
                            </Button>
                            {error && <p className="text-red-400 text-sm">{error}</p>}
                        </div>
                    </Card>
                </div>

                <div>
                    <Card className="h-full min-h-[400px] flex items-center justify-center bg-dark-800/50">
                        {loading ? (
                            <div className="text-center">
                                <div className="animate-spin h-8 w-8 border-2 border-primary-500 border-t-transparent rounded-full mx-auto mb-4"></div>
                                <p className="text-white/60">Generating...</p>
                            </div>
                        ) : result ? (
                            <img src={result.url} alt="Generated" className="w-full h-full object-contain rounded-lg" />
                        ) : (
                            <p className="text-white/40">Result will appear here</p>
                        )}
                    </Card>
                </div>
            </div>
        </div>
    );
}
