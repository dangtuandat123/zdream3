/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./index.html",
        "./src/**/*.{js,ts,jsx,tsx}",
    ],
    theme: {
        extend: {
            colors: {
                glass: {
                    bg: 'rgba(255, 255, 255, 0.03)',
                    'bg-hover': 'rgba(255, 255, 255, 0.06)',
                    'bg-active': 'rgba(255, 255, 255, 0.08)',
                    border: 'rgba(255, 255, 255, 0.08)',
                    'border-light': 'rgba(255, 255, 255, 0.12)',
                },
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                },
                dark: {
                    900: '#0a0a0f',
                    800: '#0f0f18',
                    700: '#161625',
                    600: '#1e1e32',
                },
            },
            fontFamily: {
                sans: ['Inter', 'SF Pro Display', 'ui-sans-serif', 'system-ui', '-apple-system', 'sans-serif'],
                mono: ['JetBrains Mono', 'SF Mono', 'ui-monospace', 'monospace'],
            },
            backdropBlur: {
                'xs': '2px',
                'glass': '12px',
                'glass-heavy': '24px',
            },
            boxShadow: {
                'glass': 'inset 0 1px 1px rgba(255,255,255,0.05)',
                'glass-glow': '0 0 40px rgba(59, 130, 246, 0.15)',
                'glass-lg': '0 8px 32px rgba(0, 0, 0, 0.4)',
            },
        },
    },
    plugins: [],
}
