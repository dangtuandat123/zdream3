import { forwardRef, type InputHTMLAttributes } from 'react';
import { cn } from '@/utils/cn';

export interface InputProps extends InputHTMLAttributes<HTMLInputElement> {
    error?: string;
    leftIcon?: React.ReactNode;
    rightIcon?: React.ReactNode;
}

export const Input = forwardRef<HTMLInputElement, InputProps>(
    ({ className, error, leftIcon, rightIcon, ...props }, ref) => {
        return (
            <div className="relative">
                {leftIcon && (
                    <div className="absolute left-3 top-1/2 -translate-y-1/2 text-white/40">
                        {leftIcon}
                    </div>
                )}
                <input
                    ref={ref}
                    className={cn(
                        `w-full h-11 px-4 rounded-lg
             bg-white/[0.03] backdrop-blur-[8px]
             border border-white/[0.08]
             text-white/90 placeholder:text-white/40
             text-sm
             focus:outline-none focus:ring-2 focus:ring-primary-500/40
             focus:border-primary-500/50
             transition-all duration-200`,
                        error && 'border-red-500/50 focus:ring-red-500/40',
                        leftIcon && 'pl-10',
                        rightIcon && 'pr-10',
                        className
                    )}
                    {...props}
                />
                {rightIcon && (
                    <div className="absolute right-3 top-1/2 -translate-y-1/2 text-white/40">
                        {rightIcon}
                    </div>
                )}
                {error && (
                    <p className="text-red-400 text-xs mt-1.5">{error}</p>
                )}
            </div>
        );
    }
);
Input.displayName = 'Input';
