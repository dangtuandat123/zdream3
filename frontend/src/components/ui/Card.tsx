import { cn } from '@/utils/cn';
import { type HTMLAttributes, forwardRef } from 'react';

interface CardProps extends HTMLAttributes<HTMLDivElement> {
    variant?: 'glass' | 'solid' | 'outline';
    interactive?: boolean;
}

export const Card = forwardRef<HTMLDivElement, CardProps>(
    ({ className, variant = 'glass', interactive = false, ...props }, ref) => {
        const variants = {
            glass: `
        bg-white/[0.03] backdrop-blur-[12px] saturate-[180%]
        border border-white/[0.08]
        shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)]
      `,
            solid: `
        bg-dark-800/80
        border border-white/[0.05]
      `,
            outline: `
        bg-transparent
        border border-white/[0.1]
      `,
        };

        return (
            <div
                ref={ref}
                className={cn(
                    'rounded-xl p-6',
                    variants[variant],
                    interactive && 'hover:bg-white/[0.06] hover:border-white/[0.12] transition-all duration-200 cursor-pointer',
                    className
                )}
                {...props}
            />
        );
    }
);
Card.displayName = 'Card';

export const CardHeader = ({ className, ...props }: HTMLAttributes<HTMLDivElement>) => (
    <div className={cn('mb-4', className)} {...props} />
);

export const CardTitle = ({ className, ...props }: HTMLAttributes<HTMLHeadingElement>) => (
    <h3 className={cn('text-lg font-semibold text-white/95', className)} {...props} />
);

export const CardDescription = ({ className, ...props }: HTMLAttributes<HTMLParagraphElement>) => (
    <p className={cn('text-sm text-white/60 mt-1', className)} {...props} />
);

export const CardContent = ({ className, ...props }: HTMLAttributes<HTMLDivElement>) => (
    <div className={cn('', className)} {...props} />
);

export const CardFooter = ({ className, ...props }: HTMLAttributes<HTMLDivElement>) => (
    <div className={cn('mt-6 flex items-center gap-3', className)} {...props} />
);
