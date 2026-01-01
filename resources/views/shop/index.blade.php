<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>differentclubs | Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Playfair Display', 'serif'] },
                    colors: { gray: { 50:'#fafafa',100:'#f5f5f5',200:'#e5e5e5',300:'#d4d4d4',400:'#a3a3a3',500:'#737373',600:'#525252',700:'#404040',800:'#262626',900:'#171717' } }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .cart-drawer { transition: transform 0.3s ease-in-out; }
        .cart-drawer.open { transform: translateX(0); }
        .product-card:hover .quick-actions { opacity: 1; transform: translateY(0); }
        .quick-actions { transition: all 0.2s ease-in-out; opacity: 0; transform: translateY(10px); }
        .modal-overlay { background-color: rgba(0, 0, 0, 0.5); transition: opacity 0.3s ease; }
        .toast { animation: slideIn 0.3s forwards, fadeOut 0.5s forwards 2.5s; }
        @keyframes slideIn { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
        [data-parallax] { will-change: transform; }
        .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.6s ease, transform 0.6s ease; transition-delay: var(--reveal-delay, 0s); }
        .reveal.revealed { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="font-sans text-gray-900 bg-white antialiased" x-data="app()" x-cloak>
    <script>
        window.__PRODUCTS__ = @json($products ?? []);
        window.__USER__ = @json($user ?? null);
    </script>

    @include('shop.components.navbar')
    @include('shop.components.featured-products')
    @include('shop.components.footer')
    @include('shop.components.modals')
    @include('shop.components.toast')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('app', () => ({
                searchOpen: false,
                cartOpen: false,
                checkoutOpen: false,
                quickViewOpen: false,
                sortBy: 'latest',
                filterCategory: 'all',
                selectedSize: 'M',
                selectedColor: 'Black',
                quantity: 1,
                quickViewProduct: {},
                isNavStuck: false,
                userMenuOpen: false,
                user: window.__USER__ ? {
                    ...window.__USER__,
                    isAuthenticated: true,
                    get initials() {
                        return (this.name || '').split(' ').map(n => n[0]).join('').slice(0,2).toUpperCase();
                    }
                } : {
                    name: 'Guest',
                    email: 'guest@example.com',
                    isAuthenticated: false,
                    get initials() { return 'GU'; }
                },
                cart: [],
                checkoutInfo: {
                    fullName: '',
                    email: '',
                    phone: '',
                    address: '',
                    city: '',
                    postalCode: '',
                    country: 'United States',
                    shippingMethod: 'standard',
                    paymentMethod: 'credit-card'
                },
                toast: { show: false, message: '' },

                get cartCount() { return this.cart.reduce((t, i) => t + i.quantity, 0); },
                get cartTotal() { return this.cart.reduce((t, i) => t + (i.price * i.quantity), 0); },

                get filteredProducts() {
                    let products = [...this.products];
                    if (this.filterCategory !== 'all') products = products.filter(p => p.category === this.filterCategory);
                    if (this.sortBy === 'price-low') {
                        products.sort((a,b) => (a.discountPercent ? a.price*(1-a.discountPercent/100) : a.price) - (b.discountPercent ? b.price*(1-b.discountPercent/100) : b.price));
                    } else if (this.sortBy === 'price-high') {
                        products.sort((a,b) => (b.discountPercent ? b.price*(1-b.discountPercent/100) : b.price) - (a.discountPercent ? a.price*(1-a.discountPercent/100) : a.price));
                    } else {
                        products.sort((a,b) => b.id - a.id);
                    }
                    return products;
                },

                formatRupiah(value) {
                    const number = Number(value) || 0;
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                },

                products: (window.__PRODUCTS__ && window.__PRODUCTS__.length) ? window.__PRODUCTS__ : [
                    { id: 1, name: "Classic White Shirt", category: "tops", price: 599900, rating: 4.8, isNew: true, isBestSeller: true, discountPercent: 0, colors: ["White", "Black", "Gray"], sizes: ["S", "M", "L", "XL"], stock: 50 },
                    { id: 2, name: "Black Slim Jeans", category: "bottoms", price: 899900, rating: 4.7, isNew: false, isBestSeller: true, discountPercent: 0, colors: ["Black"], sizes: ["28", "30", "32", "34"], stock: 30 },
                    { id: 3, name: "Oversized Gray Sweater", category: "tops", price: 799900, rating: 4.6, isNew: true, isBestSeller: false, discountPercent: 20, colors: ["Gray", "Black"], sizes: ["S", "M", "L", "XL"], stock: 25 },
                    { id: 4, name: "Wool Blend Coat", category: "outerwear", price: 1999900, rating: 4.9, isNew: false, isBestSeller: true, discountPercent: 0, colors: ["Black", "Gray"], sizes: ["S", "M", "L", "XL"], stock: 15 },
                    { id: 5, name: "Minimalist Watch", category: "accessories", price: 1499900, rating: 4.8, isNew: false, isBestSeller: false, discountPercent: 15, colors: ["Black", "White"], sizes: ["One Size"], stock: 40 },
                    { id: 6, name: "Linen Black Pants", category: "bottoms", price: 699900, rating: 4.5, isNew: true, isBestSeller: false, discountPercent: 0, colors: ["Black"], sizes: ["S", "M", "L", "XL"], stock: 35 },
                    { id: 7, name: "Cotton White T-Shirt", category: "tops", price: 299900, rating: 4.4, isNew: false, isBestSeller: false, discountPercent: 0, colors: ["White", "Black"], sizes: ["S", "M", "L", "XL"], stock: 60 },
                    { id: 8, name: "Cashmere Scarf", category: "accessories", price: 899900, rating: 4.7, isNew: false, isBestSeller: true, discountPercent: 10, colors: ["Gray", "Black"], sizes: ["One Size"], stock: 20 }
                ],

                openQuickView(product) {
                    this.quickViewProduct = product;
                    this.selectedSize = product.sizes[0];
                    this.selectedColor = product.colors[0];
                    this.quantity = 1;
                    this.quickViewOpen = true;
                },
                addToCart(product, size, color, quantity = 1) {
                    const existing = this.cart.findIndex(i => i.id === product.id && i.size === size && i.color === color);
                    const price = product.discountPercent ? product.price * (1 - product.discountPercent/100) : product.price;
                    if (existing >= 0) this.cart[existing].quantity += quantity;
                    else this.cart.push({ id: product.id, name: product.name, price, size, color, quantity });
                    this.saveCart(); this.showToast(`${product.name} added to cart`);
                },
                removeFromCart(index) { const removed = this.cart.splice(index,1)[0]; this.saveCart(); this.showToast(`${removed.name} removed from cart`); },
                updateQuantity(index, newQty) { if (newQty < 1) return; this.cart[index].quantity = newQty; this.saveCart(); },
                saveCart() { localStorage.setItem('noirCart', JSON.stringify(this.cart)); },
                placeOrder() { this.showToast("Order placed successfully (simulated)"); this.cart = []; this.saveCart(); this.checkoutOpen = false; },
                showToast(message) { this.toast.message = message; this.toast.show = true; setTimeout(() => { this.toast.show = false; }, 3000); },
                handleScroll() { this.isNavStuck = window.scrollY > 30; },

                init() {
                    const savedCart = localStorage.getItem('noirCart');
                    if (savedCart) this.cart = JSON.parse(savedCart);
                    window.addEventListener('scroll', this.handleScroll);
                    this.handleScroll();
                },
            }));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        const parallaxEls = [];
        const animateEls = [];
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-parallax]').forEach(el => parallaxEls.push(el));
            document.querySelectorAll('[data-animate]').forEach(el => {
                const delay = el.dataset.animateDelay;
                if (delay) el.style.setProperty('--reveal-delay', delay);
                animateEls.push(el);
            });

            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            animateEls.forEach(el => observer.observe(el));
        });
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            parallaxEls.forEach(el => {
                const speed = parseFloat(el.dataset.parallaxSpeed || 0.3);
                el.style.transform = `translateY(${scrolled * speed * -1}px)`;
            });
        }, { passive: true });
    </script>
</body>
</html>
