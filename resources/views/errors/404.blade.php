<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 | Page Not Found</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --cursor-x: 50%;
            --cursor-y: 50%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #050505;
            color: #ffffff;
            overflow: hidden;
            margin: 0;
            cursor: default;
        }

        .bg-noise {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            z-index: 10;
        }

        .spotlight {
            position: fixed;
            inset: 0;
            background: radial-gradient(
                circle 600px at var(--cursor-x) var(--cursor-y),
                rgba(255, 255, 255, 0.08),
                transparent 80%
            );
            z-index: 1;
        }

        .grid-bg {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            mask-image: radial-gradient(circle 800px at var(--cursor-x) var(--cursor-y), black, transparent);
            -webkit-mask-image: radial-gradient(circle 800px at var(--cursor-x) var(--cursor-y), black, transparent);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
    </style>
</head>
<body class="h-screen w-full flex items-center justify-center relative selection:bg-white selection:text-black">

    <div class="bg-noise"></div>
    <div class="spotlight" id="spotlight"></div>
    <div class="absolute inset-0 grid-bg z-0" id="grid"></div>

    <main class="relative z-20 text-center px-4 max-w-2xl w-full">
        
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-white/10 bg-white/5 mb-8 backdrop-blur-md animate-float">
            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
            <span class="text-[10px] font-bold tracking-widest uppercase text-white/60">System Error</span>
        </div>

        <div class="relative mb-2 select-none group">
            <h1 id="errorCode" class="text-[8rem] sm:text-[12rem] md:text-[15rem] leading-none font-bold tracking-tighter text-transparent bg-clip-text bg-gradient-to-b from-white to-white/10 cursor-default">
                404
            </h1>
            <h1 class="absolute inset-0 text-[8rem] sm:text-[12rem] md:text-[15rem] leading-none font-bold tracking-tighter text-white blur-2xl opacity-10 pointer-events-none">
                404
            </h1>
        </div>

        <div class="space-y-2 mb-10">
            <h2 id="errorTitle" class="text-2xl md:text-3xl font-semibold text-white">Page not found</h2>
            <p class="text-zinc-500 text-sm md:text-base max-w-md mx-auto">
                The coordinates you are looking for do not exist in this sector. 
                It might have been moved or deleted.
            </p>
        </div>

        <div class="flex justify-center">
            <button onclick="goBack()" class="group relative px-8 py-4 bg-white text-black rounded-full overflow-hidden transition-all hover:scale-105 active:scale-95">
                <div class="absolute inset-0 w-full h-full bg-zinc-200 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></div>
                <div class="relative flex items-center gap-2 font-bold text-sm tracking-wide">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>RETURN HOME</span>
                </div>
            </button>
        </div>

    </main>

    <div class="absolute bottom-8 text-[10px] text-zinc-700 font-mono tracking-widest uppercase z-20">
        ID: ERR_NULL_REF_POINTER
    </div>

    <script>
        const root = document.documentElement;

        document.addEventListener('mousemove', (e) => {
            root.style.setProperty('--cursor-x', e.clientX + 'px');
            root.style.setProperty('--cursor-y', e.clientY + 'px');
        });

        document.addEventListener('touchmove', (e) => {
            const touch = e.touches[0];
            root.style.setProperty('--cursor-x', touch.clientX + 'px');
            root.style.setProperty('--cursor-y', touch.clientY + 'px');
        });

        class TextScramble {
            constructor(el) {
                this.el = el;
                this.chars = '!<>-_\\/[]{}—=+*^?#________';
                this.update = this.update.bind(this);
            }

            setText(newText) {
                const oldText = this.el.innerText;
                const length = Math.max(oldText.length, newText.length);
                const promise = new Promise((resolve) => this.resolve = resolve);
                
                this.queue = [];
                for (let i = 0; i < length; i++) {
                    const from = oldText[i] || '';
                    const to = newText[i] || '';
                    const start = Math.floor(Math.random() * 40);
                    const end = start + Math.floor(Math.random() * 40);
                    this.queue.push({ from, to, start, end });
                }
                
                cancelAnimationFrame(this.frameRequest);
                this.frame = 0;
                this.update();
                return promise;
            }

            update() {
                let output = '';
                let complete = 0;
                
                for (let i = 0, n = this.queue.length; i < n; i++) {
                    let { from, to, start, end, char } = this.queue[i];
                    
                    if (this.frame >= end) {
                        complete++;
                        output += to;
                    } else if (this.frame >= start) {
                        if (!char || Math.random() < 0.28) {
                            char = this.randomChar();
                            this.queue[i].char = char;
                        }
                        output += `<span class="opacity-50">${char}</span>`;
                    } else {
                        output += from;
                    }
                }
                
                this.el.innerHTML = output;
                
                if (complete === this.queue.length) {
                    this.resolve();
                } else {
                    this.frameRequest = requestAnimationFrame(this.update);
                    this.frame++;
                }
            }

            randomChar() {
                return this.chars[Math.floor(Math.random() * this.chars.length)];
            }
        }

        const errorCode = document.getElementById('errorCode');
        const errorTitle = document.getElementById('errorTitle');
        
        const scramblerCode = new TextScramble(errorCode);
        const scramblerTitle = new TextScramble(errorTitle);

        window.onload = () => {
            setTimeout(() => {
                scramblerCode.setText('404');
                scramblerTitle.setText('PAGE NOT FOUND');
            }, 500);
        };

        errorCode.addEventListener('mouseenter', () => {
            scramblerCode.setText('404');
        });

        function goBack() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            
            setTimeout(() => {
                if (window.history.length > 1) {
                    window.history.back();
                } else {
                    window.location.href = '/';
                }
            }, 500);
        }
    </script>
</body>
</html>
