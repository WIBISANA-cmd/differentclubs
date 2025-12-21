<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monochrome Auth | Premium Access</title>
    <meta name="description" content="Premium Monochrome Authentication Template">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            black: '#0a0a0a',
                            dark: '#171717',
                            gray: '#737373',
                            light: '#f5f5f5',
                            white: '#ffffff',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.4s ease-out forwards',
                        'slide-up': 'slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #f0f0f0;
            color: #171717;
        }

        .bg-noise {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            opacity: 0.04;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }

        .bg-gradient-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: radial-gradient(circle at 50% 0%, #ffffff 0%, #e5e5e5 100%);
        }

        input { transition: all 0.2s ease; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d4d4d4; border-radius: 4px; }

        .spinner {
            border: 2px solid rgba(255,255,255,0.1);
            border-left-color: #fff;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
        }
        .spinner-dark {
            border: 2px solid rgba(0,0,0,0.1);
            border-left-color: #000;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        .strength-segment {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
    </style>

    </head>
<body class="flex flex-col min-h-screen items-center justify-center p-4 sm:p-6 relative overflow-x-hidden">

    <div class="bg-gradient-overlay"></div>
    <div class="bg-noise"></div>

    <div id="toast-container" class="fixed top-6 right-6 z-50 flex flex-col gap-3 pointer-events-none"></div>

    <main class="w-full max-w-[420px] mx-auto animate-slide-up relative z-10">
        
        <div class="flex flex-col items-center mb-8 text-center">
            <div class="w-12 h-12 bg-brand-black text-white rounded-xl flex items-center justify-center text-xl font-bold shadow-lg shadow-black/10 mb-4 select-none">
                M
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-brand-black">Monochrome</h1>
            <p class="text-sm text-brand-gray mt-1">Premium Digital Access</p>
        </div>

        <div class="bg-white/70 backdrop-blur-xl border border-white/40 shadow-2xl shadow-black/5 rounded-[2rem] overflow-hidden">
            
            <div id="auth-tabs" class="grid grid-cols-2 p-1.5 border-b border-gray-100/50">
                <button onclick="switchView('login')" id="tab-login" class="py-3 text-sm font-medium rounded-xl transition-all duration-300 bg-white shadow-sm text-brand-black">
                    Log In
                </button>
                <button onclick="switchView('signup')" id="tab-signup" class="py-3 text-sm font-medium rounded-xl transition-all duration-300 text-brand-gray hover:text-brand-black hover:bg-white/50">
                    Sign Up
                </button>
            </div>

            <div class="p-6 sm:p-8 relative min-h-[400px]">

                <section id="view-login" class="space-y-6 animate-fade-in">
                    <form onsubmit="handleLogin(event)" class="space-y-4">
                        <div class="space-y-1.5">
                            <label for="login-email" class="text-xs font-semibold text-brand-dark uppercase tracking-wide">Email</label>
                            <input type="email" id="login-email" required placeholder="name@example.com"
                                class="w-full px-4 py-3.5 bg-brand-light/50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-brand-black focus:border-brand-black focus:bg-white placeholder-gray-400 transition-shadow">
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex justify-between items-center">
                                <label for="login-password" class="text-xs font-semibold text-brand-dark uppercase tracking-wide">Password</label>
                                <button type="button" onclick="switchView('forgot')" class="text-xs text-brand-gray hover:text-brand-black transition-colors font-medium">Forgot password?</button>
                            </div>
                            <div class="relative">
                                <input type="password" id="login-password" required placeholder="••••••••"
                                    class="w-full px-4 py-3.5 bg-brand-light/50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-brand-black focus:border-brand-black focus:bg-white placeholder-gray-400">
                                <button type="button" onclick="togglePassword('login-password', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-black p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="remember-me" class="w-4 h-4 rounded border-gray-300 text-brand-black focus:ring-brand-black accent-black cursor-pointer">
                            <label for="remember-me" class="text-sm text-brand-gray cursor-pointer select-none">Remember me</label>
                        </div>

                        <button type="submit" id="btn-login" class="w-full py-3.5 bg-brand-black hover:bg-brand-dark text-white rounded-xl font-semibold text-sm transition-all transform active:scale-[0.98] shadow-lg shadow-black/20 flex justify-center items-center gap-2">
                            <span>Log In</span>
                        </button>
                    </form>

                    <div class="relative">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                        <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-gray-400 font-medium">Or continue with</span></div>
                    </div>

                    <button onclick="handleGoogleAuth()" class="w-full py-3.5 bg-white border border-gray-200 hover:bg-gray-50 text-brand-black rounded-xl font-medium text-sm transition-all flex justify-center items-center gap-3 shadow-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.26.81-.58z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        Google
                        <div id="google-login-placeholder" class="hidden"></div> </button>
                </section>

                <section id="view-signup" class="space-y-6 animate-fade-in hidden">
                    <form onsubmit="handleSignup(event)" class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-brand-dark uppercase tracking-wide">Full Name</label>
                            <input type="text" required placeholder="John Doe" class="w-full px-4 py-3.5 bg-brand-light/50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-brand-black focus:border-brand-black transition-shadow">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-brand-dark uppercase tracking-wide">Email</label>
                            <input type="email" id="signup-email" required placeholder="name@example.com" class="w-full px-4 py-3.5 bg-brand-light/50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-brand-black focus:border-brand-black transition-shadow">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-brand-dark uppercase tracking-wide">Password</label>
                            <div class="relative">
                                <input type="password" id="signup-password" required placeholder="Min 8 chars" class="w-full px-4 py-3.5 bg-brand-light/50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-brand-black focus:border-brand-black">
                                <button type="button" onclick="togglePassword('signup-password', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-black p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <div class="flex gap-1 h-1 mt-2">
                                <div id="strength-1" class="strength-segment flex-1 bg-gray-200"></div>
                                <div id="strength-2" class="strength-segment flex-1 bg-gray-200"></div>
                                <div id="strength-3" class="strength-segment flex-1 bg-gray-200"></div>
                                <div id="strength-4" class="strength-segment flex-1 bg-gray-200"></div>
                            </div>
                            <p id="password-feedback" class="text-[10px] text-gray-400 text-right h-3">Weak</p>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-brand-dark uppercase tracking-wide">Confirm Password</label>
                            <input type="password" id="signup-confirm" required placeholder="Repeat password" class="w-full px-4 py-3.5 bg-brand-light/50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-brand-black focus:border-brand-black">
                            <p id="match-error" class="text-xs text-red-500 hidden mt-1">Passwords do not match</p>
                        </div>

                        <div class="flex items-start space-x-2 pt-1">
                            <input type="checkbox" required id="terms" class="mt-1 w-4 h-4 rounded border-gray-300 text-brand-black focus:ring-brand-black accent-black cursor-pointer">
                            <label for="terms" class="text-xs text-brand-gray leading-tight cursor-pointer">I agree to the <a href="#" class="text-brand-black underline decoration-1 underline-offset-2">Terms of Service</a> and <a href="#" class="text-brand-black underline decoration-1 underline-offset-2">Privacy Policy</a>.</label>
                        </div>

                        <button type="submit" id="btn-signup" class="w-full py-3.5 bg-brand-black hover:bg-brand-dark text-white rounded-xl font-semibold text-sm transition-all transform active:scale-[0.98] shadow-lg shadow-black/20 flex justify-center items-center gap-2">
                            <span>Create Account</span>
                        </button>
                    </form>

                     <div class="relative">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                        <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-gray-400 font-medium">Or</span></div>
                    </div>

                    <button onclick="handleGoogleAuth()" class="w-full py-3.5 bg-white border border-gray-200 hover:bg-gray-50 text-brand-black rounded-xl font-medium text-sm transition-all flex justify-center items-center gap-3 shadow-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.26.81-.58z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        Sign up with Google
                    </button>
                </section>

                <section id="view-forgot" class="space-y-6 animate-fade-in hidden">
                    <div class="text-center">
                        <div class="inline-flex p-3 rounded-full bg-gray-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-black"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-brand-black">Forgot password?</h2>
                        <p class="text-sm text-brand-gray mt-2">No worries, we'll send you reset instructions.</p>
                    </div>

                    <form onsubmit="handleForgot(event)" class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-brand-dark uppercase tracking-wide">Email</label>
                            <input type="email" required placeholder="name@example.com" class="w-full px-4 py-3.5 bg-brand-light/50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-brand-black focus:border-brand-black">
                        </div>
                        <button type="submit" id="btn-forgot" class="w-full py-3.5 bg-brand-black hover:bg-brand-dark text-white rounded-xl font-semibold text-sm transition-all transform active:scale-[0.98] shadow-lg shadow-black/20 flex justify-center items-center gap-2">
                            <span>Send Reset Link</span>
                        </button>
                    </form>

                    <button onclick="switchView('login')" class="w-full flex items-center justify-center gap-2 text-sm text-brand-gray hover:text-brand-black transition-colors font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        Back to log in
                    </button>
                </section>

                <section id="view-sent" class="space-y-6 animate-fade-in hidden">
                    <div class="text-center">
                        <div class="inline-flex p-3 rounded-full bg-green-100 text-green-600 mb-4">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-brand-black">Check your email</h2>
                        <p class="text-sm text-brand-gray mt-2">We sent a password reset link to <span class="text-brand-black font-semibold">your@email.com</span></p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-xs text-gray-500 text-center">
                        <p>Did not receive the email? <a href="#" class="text-brand-black underline">Click to resend</a></p>
                    </div>

                    <button onclick="switchView('login')" class="w-full flex items-center justify-center gap-2 text-sm text-brand-gray hover:text-brand-black transition-colors font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        Back to log in
                    </button>

                    <div class="pt-4 border-t border-dashed border-gray-200">
                        <button onclick="switchView('reset')" class="w-full py-2 bg-gray-100 text-gray-500 text-xs rounded-lg hover:bg-gray-200">
                            (Simulation: Click Reset Link)
                        </button>
                    </div>
                </section>

                <section id="view-reset" class="space-y-6 animate-fade-in hidden">
                    <div class="text-center">
                        <div class="inline-flex p-3 rounded-full bg-gray-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-black"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-brand-black">Set new password</h2>
                        <p class="text-sm text-brand-gray mt-2">Your new password must be different to previously used passwords.</p>
                    </div>

                    <form onsubmit="handleReset(event)" class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-brand-dark uppercase tracking-wide">New Password</label>
                            <div class="relative">
                                <input type="password" id="reset-pass" required placeholder="Min 8 chars" class="w-full px-4 py-3.5 bg-brand-light/50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-brand-black focus:border-brand-black">
                                <button type="button" onclick="togglePassword('reset-pass', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-black p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-brand-dark uppercase tracking-wide">Confirm Password</label>
                            <div class="relative">
                                <input type="password" id="reset-confirm" required placeholder="Repeat password" class="w-full px-4 py-3.5 bg-brand-light/50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-brand-black focus:border-brand-black">
                            </div>
                        </div>

                        <button type="submit" id="btn-reset" class="w-full py-3.5 bg-brand-black hover:bg-brand-dark text-white rounded-xl font-semibold text-sm transition-all transform active:scale-[0.98] shadow-lg shadow-black/20 flex justify-center items-center gap-2">
                            <span>Reset Password</span>
                        </button>
                    </form>
                    
                    <button onclick="switchView('login')" class="w-full flex items-center justify-center gap-2 text-sm text-brand-gray hover:text-brand-black transition-colors font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        Back to log in
                    </button>
                </section>
                
                <section id="view-success" class="space-y-6 animate-fade-in hidden text-center pt-8">
                     <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto overflow-hidden border-4 border-white shadow-lg">
                        <img src="https://ui-avatars.com/api/?name=User&background=0a0a0a&color=fff" alt="User" class="w-full h-full object-cover">
                     </div>
                     <div>
                        <h2 class="text-2xl font-bold text-brand-black">Welcome, User!</h2>
                        <p class="text-brand-gray">You have successfully logged in.</p>
                     </div>
                     <div class="pt-6">
                         <button onclick="location.reload()" class="px-6 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                             Sign Out
                         </button>
                     </div>
                </section>

            </div>
        </div>

        <footer class="mt-8 text-center">
            <p class="text-xs text-brand-gray">© 2025 Monochrome Auth. All rights reserved.</p>
        </footer>

    </main>

    <script>
        const $ = (selector) => document.querySelector(selector);
        const $$ = (selector) => document.querySelectorAll(selector);

        const views = ['login', 'signup', 'forgot', 'sent', 'reset', 'success'];
        
        function switchView(viewName) {
            views.forEach(v => {
                const el = $(`#view-${v}`);
                if(el) el.classList.add('hidden');
            });

            const target = $(`#view-${viewName}`);
            if(target) {
                target.classList.remove('hidden');
                target.classList.remove('animate-fade-in');
                void target.offsetWidth;
                target.classList.add('animate-fade-in');
            }

            const tabContainer = $('#auth-tabs');
            const tabLogin = $('#tab-login');
            const tabSignup = $('#tab-signup');

            if (viewName === 'login') {
                tabContainer.classList.remove('hidden');
                tabLogin.classList.replace('text-brand-gray', 'text-brand-black');
                tabLogin.classList.replace('hover:bg-white/50', 'bg-white');
                tabLogin.classList.add('shadow-sm', 'bg-white');
                
                tabSignup.classList.replace('text-brand-black', 'text-brand-gray');
                tabSignup.classList.remove('shadow-sm', 'bg-white');
                tabSignup.classList.add('hover:bg-white/50');
            } else if (viewName === 'signup') {
                tabContainer.classList.remove('hidden');
                tabSignup.classList.replace('text-brand-gray', 'text-brand-black');
                tabSignup.classList.replace('hover:bg-white/50', 'bg-white');
                tabSignup.classList.add('shadow-sm', 'bg-white');

                tabLogin.classList.replace('text-brand-black', 'text-brand-gray');
                tabLogin.classList.remove('shadow-sm', 'bg-white');
                tabLogin.classList.add('hover:bg-white/50');
            } else {
                tabContainer.classList.add('hidden');
            }
        }

        function togglePassword(inputId, btn) {
            const input = $(`#${inputId}`);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            
            if(isPassword) {
                 btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>`;
            } else {
                 btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`;
            }
        }

        function setLoading(btnId, isLoading, text = 'Processing') {
            const btn = $(`#${btnId}`);
            if (isLoading) {
                btn.disabled = true;
                btn.dataset.originalText = btn.innerHTML;
                btn.innerHTML = `<div class="spinner"></div> <span>${text}...</span>`;
                btn.classList.add('opacity-80', 'cursor-not-allowed');
            } else {
                btn.disabled = false;
                btn.innerHTML = btn.dataset.originalText;
                btn.classList.remove('opacity-80', 'cursor-not-allowed');
            }
        }

        function showToast(message, type = 'success') {
            const container = $('#toast-container');
            const toast = document.createElement('div');
            
            const icon = type === 'success' 
                ? `<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`
                : `<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

            toast.className = `flex items-center gap-3 bg-white border border-gray-200 shadow-xl p-4 rounded-xl transform translate-x-full transition-all duration-300 pointer-events-auto min-w-[300px]`;
            toast.innerHTML = `
                ${icon}
                <div>
                    <h4 class="font-semibold text-sm text-brand-black">${type === 'success' ? 'Success' : 'Error'}</h4>
                    <p class="text-xs text-brand-gray">${message}</p>
                </div>
            `;

            container.appendChild(toast);
            
            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-full');
            });

            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        $('#signup-password').addEventListener('input', function(e) {
            const val = e.target.value;
            const feedback = $('#password-feedback');
            const segments = [$('#strength-1'), $('#strength-2'), $('#strength-3'), $('#strength-4')];
            
            let score = 0;
            if (val.length > 5) score++;
            if (val.length > 8) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            segments.forEach(s => s.className = 'strength-segment flex-1 bg-gray-200');
            feedback.innerText = 'Weak';
            feedback.className = 'text-[10px] text-right h-3 text-gray-400';

            if (val.length > 0) {
                if (score <= 1) {
                    segments[0].classList.replace('bg-gray-200', 'bg-red-400');
                    feedback.innerText = 'Weak';
                    feedback.classList.replace('text-gray-400', 'text-red-500');
                } else if (score === 2) {
                    segments[0].classList.replace('bg-gray-200', 'bg-yellow-400');
                    segments[1].classList.replace('bg-gray-200', 'bg-yellow-400');
                    feedback.innerText = 'Medium';
                    feedback.classList.replace('text-gray-400', 'text-yellow-600');
                } else if (score === 3) {
                    segments[0].classList.replace('bg-gray-200', 'bg-green-400');
                    segments[1].classList.replace('bg-gray-200', 'bg-green-400');
                    segments[2].classList.replace('bg-gray-200', 'bg-green-400');
                    feedback.innerText = 'Strong';
                    feedback.classList.replace('text-gray-400', 'text-green-600');
                } else {
                    segments.forEach(s => s.classList.replace('bg-gray-200', 'bg-green-500'));
                    feedback.innerText = 'Very Strong';
                    feedback.classList.replace('text-gray-400', 'text-green-700');
                }
            }
        });

        function handleSignup(e) {
            e.preventDefault();
            const pass = $('#signup-password').value;
            const confirm = $('#signup-confirm').value;

            if (pass !== confirm) {
                $('#match-error').classList.remove('hidden');
                $('#signup-confirm').classList.add('border-red-500', 'ring-1', 'ring-red-500');
                return;
            } else {
                $('#match-error').classList.add('hidden');
                $('#signup-confirm').classList.remove('border-red-500', 'ring-1', 'ring-red-500');
            }

            setLoading('btn-signup', true, 'Creating Account');
            
            setTimeout(() => {
                setLoading('btn-signup', false);
                showToast('Account created successfully!');
                switchView('success');
            }, 1500);
        }

        function handleLogin(e) {
            e.preventDefault();
            setLoading('btn-login', true, 'Authenticating');

            setTimeout(() => {
                setLoading('btn-login', false);
                showToast('Logged in successfully!');
                switchView('success');
            }, 1500);
        }

        function handleForgot(e) {
            e.preventDefault();
            setLoading('btn-forgot', true, 'Sending');
            
            setTimeout(() => {
                setLoading('btn-forgot', false);
                switchView('sent');
            }, 1200);
        }

        function handleReset(e) {
            e.preventDefault();
            const pass = $('#reset-pass').value;
            const confirm = $('#reset-confirm').value;

            if (pass !== confirm || pass.length < 1) {
                showToast('Passwords do not match', 'error');
                return;
            }

            setLoading('btn-reset', true, 'Updating');

            setTimeout(() => {
                setLoading('btn-reset', false);
                showToast('Password updated! Please login.');
                switchView('login');
            }, 1500);
        }

        function handleGoogleAuth() {
            showToast('Google Auth Simulated', 'success');
        }

        window.onload = () => {
            switchView('login');
        };

    </script>
</body>
</html>
