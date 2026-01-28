import { useEffect, useState } from 'react';
import { getStyles } from '../services/api';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '../components/ui/Card';
import { Button } from '../components/ui/Button';
import { Link } from 'react-router-dom';

interface Style {
    id: number;
    name: string;
    description: string;
    thumbnail_url: string;
    price: number;
}

export default function Home() {
    const [styles, setStyles] = useState<Style[]>([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        getStyles()
            .then(res => setStyles(res.data))
            .catch(err => console.error(err))
            .finally(() => setLoading(false));
    }, []);

    if (loading) return <div className="text-center py-20">Loading styles...</div>;

    return (
        <div>
            <h1 className="text-3xl font-bold mb-8">Choose a Style</h1>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {styles.map(style => (
                    <Card key={style.id} className="group hover:scale-[1.02] transition-transform duration-300">
                        <div className="aspect-video rounded-lg bg-dark-800 mb-4 overflow-hidden">
                            {style.thumbnail_url ? (
                                <img src={style.thumbnail_url} alt={style.name} className="w-full h-full object-cover" />
                            ) : (
                                <div className="w-full h-full flex items-center justify-center text-white/20">No Image</div>
                            )}
                        </div>
                        <CardHeader className="p-0 mb-2">
                            <CardTitle>{style.name}</CardTitle>
                            <CardDescription>{style.description}</CardDescription>
                        </CardHeader>
                        <CardFooter className="p-0 mt-4 flex justify-between items-center">
                            <span className="text-primary-400 font-medium">{style.price} Credits</span>
                            <Link to={`/studio/${style.id}`}>
                                <Button size="sm">Create</Button>
                            </Link>
                        </CardFooter>
                    </Card>
                ))}
            </div>
        </div>
    );
}
