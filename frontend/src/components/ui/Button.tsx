import { forwardRef, type ButtonHTMLAttributes } from 'react';
import { cva, type VariantProps } from 'class-variance-authority';
import { cn } from '@/utils/cn';

const buttonVariants = cva(
    `inline-flex items-center justify-center gap-2 
   font-medium transition-all duration-200 
   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500/50
   disabled:opacity-50 disabled:cursor-not-allowed
   active:scale-[0.98]`,
    {
        variants: {
            variant: {
                primary: `
          bg-gradient-to-r from-primary-500 to-primary-600
          text-white shadow-lg shadow-primary-500/25
          hover:from-primary-400 hover:to-primary-500
          hover:shadow-primary-500/40
        `,
                secondary: `
          bg-white/[0.05] backdrop-blur-[12px]
          border border-white/[0.1]
          text-white/90
          hover:bg-white/[0.08] hover:border-white/[0.15]
        `,
                ghost: `
          bg-transparent text-white/70
          hover:bg-white/[0.05] hover:text-white
        `,
                danger: `
          bg-red-500/80 text-white
          hover:bg-red-500
          shadow-lg shadow-red-500/25
        `,
                outline: `
          bg-transparent border border-white/[0.15]
          text-white/80
          hover:bg-white/[0.05] hover:border-white/[0.25]
        `,
            },
            size: {
                sm: 'h-8 px-3 text-sm rounded-md',
                md: 'h-10 px-4 text-sm rounded-lg',
                lg: 'h-12 px-6 text-base rounded-lg',
                xl: 'h-14 px-8 text-lg rounded-xl',
                icon: 'h-10 w-10 rounded-lg',
            },
        },
        defaultVariants: {
            variant: 'primary',
            size: 'md',
        },
    }
);

export interface ButtonProps
    extends ButtonHTMLAttributes<HTMLButtonElement>,
    VariantProps<typeof buttonVariants> {
    isLoading?: boolean;
}

export const Button = forwardRef<HTMLButtonElement, ButtonProps>(
    ({ className, variant, size, isLoading, children, disabled, ...props }, ref) => {
        return (
            <button
                ref={ref}
                className={cn(buttonVariants({ variant, size }), className)}
                disabled={disabled || isLoading}
                {...props}
            >
                {isLoading && (
                    <svg className="animate-spin h-4 w-4" viewBox="0 0 24 24">
                        <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" fill="none" />
                        <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                )}
                {children}
            </button>
        );
    }
);
Button.displayName = 'Button';
