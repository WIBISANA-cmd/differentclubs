<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | differentclubs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet">
    <script src="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: { gray: { 50:'#F9FAFB',100:'#F3F4F6',200:'#E5E7EB',300:'#D1D5DB',400:'#9CA3AF',500:'#6B7280',600:'#4B5563',700:'#374151',800:'#1F2937',900:'#111827' } },
                    boxShadow: { subtle:'0 1px 2px 0 rgba(0,0,0,0.05)', card:'0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.02)' }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 space-y-4 sm:space-y-0">
            <div>
                <nav class="flex text-sm text-gray-500 mb-1" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li><a href="{{ route('dashboard') }}" class="hover:text-gray-900 transition">Dashboard</a></li>
                        <li><span class="text-gray-300">/</span></li>
                        <li><span class="text-gray-900 font-medium">Settings</span></li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Profile Settings</h1>
            </div>
            <div class="text-sm text-gray-500">
                {{ auth()->user()->email }}
            </div>
        </div>

        @if (session('status'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
            <aside class="py-6 px-2 lg:col-span-3 lg:py-0 lg:px-0 mb-6 lg:mb-0">
                <nav class="space-y-1">
                    <span class="bg-gray-100 text-gray-900 group border-l-4 border-gray-900 px-3 py-2 flex items-center text-sm font-medium rounded-r-md">
                        <svg class="text-gray-900 flex-shrink-0 -ml-1 mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="truncate">Profile</span>
                    </span>
                </nav>
            </aside>

            <main class="lg:col-span-9 space-y-6">
                <div class="bg-white shadow-card rounded-2xl border border-gray-200">
                    <div class="p-6 flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
                        <div class="relative group">
                            <img id="avatarPreview" class="h-24 w-24 rounded-full object-cover ring-4 ring-gray-50" src="{{ auth()->user()->profile_photo_path ? Storage::url(auth()->user()->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=111827&color=fff' }}" alt="Avatar">
                            <form id="avatarForm" action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data" class="hidden">
                                @csrf
                                <input type="file" name="avatar" id="avatarInput" accept="image/*">
                                <input type="hidden" name="crop[x]" id="cropX">
                                <input type="hidden" name="crop[y]" id="cropY">
                                <input type="hidden" name="crop[width]" id="cropW">
                                <input type="hidden" name="crop[height]" id="cropH">
                            </form>
                        </div>
                        <div class="text-center sm:text-left flex-1">
                            <div class="flex items-center justify-center sm:justify-start space-x-2">
                                <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ auth()->user()->email }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Manage your account information</p>
                            <div class="mt-4">
                                <button type="button" onclick="document.getElementById('avatarInput').click()" class="px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">Upload new photo</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-card rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-6">Personal Information</h3>
                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2 px-3 border">
                                @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2 px-3 border">
                                @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gray-900 hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white shadow-card rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-6">Update Password</h3>
                    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('put')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" name="current_password" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2 px-3 border">
                            @error('current_password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2 px-3 border">
                            @error('password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2 px-3 border">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gray-900 hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-red-50 shadow-card rounded-2xl border border-red-100 p-6">
                    <h3 class="text-lg font-semibold leading-6 text-red-700 mb-2">Danger Zone</h3>
                    <p class="text-sm text-red-600 mb-6">Delete your account permanently.</p>
                    <form method="post" action="{{ route('profile.destroy') }}" class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        @csrf
                        @method('delete')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete your account?')" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete Account
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
<div id="cropperModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden">
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Atur Pemotongan Foto</h3>
            <button id="closeCropper" class="text-gray-500 hover:text-gray-800">&times;</button>
        </div>
        <div class="p-4">
            <div class="w-full h-96 bg-gray-50 border border-dashed border-gray-200 rounded-xl overflow-hidden flex items-center justify-center">
                <img id="cropperTarget" class="max-h-96" alt="Crop target">
            </div>
            <div class="mt-4 flex justify-end gap-3">
                <button id="cancelCropper" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Batal</button>
                <button id="saveCropper" class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-black">Simpan & Upload</button>
            </div>
        </div>
    </div>
</div>
<script>
    const avatarInput = document.getElementById('avatarInput');
    const avatarForm = document.getElementById('avatarForm');
    const cropperModal = document.getElementById('cropperModal');
    const cropperTarget = document.getElementById('cropperTarget');
    const closeCropper = document.getElementById('closeCropper');
    const cancelCropper = document.getElementById('cancelCropper');
    const saveCropper = document.getElementById('saveCropper');
    const previewImg = document.getElementById('avatarPreview');
    let cropperInstance = null;

    function openCropper(src) {
        cropperTarget.src = src;
        cropperModal.classList.remove('hidden');
        setTimeout(() => {
            cropperInstance?.destroy();
            cropperInstance = new Cropper(cropperTarget, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                background: false,
            });
        }, 50);
    }

    function closeCropperModal() {
        cropperModal.classList.add('hidden');
        cropperInstance?.destroy();
        cropperInstance = null;
        avatarInput.value = '';
    }

    avatarInput?.addEventListener('change', () => {
        if (avatarInput.files && avatarInput.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => openCropper(e.target.result);
            reader.readAsDataURL(avatarInput.files[0]);
        }
    });

    closeCropper.onclick = cancelCropper.onclick = () => closeCropperModal();

    saveCropper.onclick = () => {
        if (!cropperInstance) return;
        const data = cropperInstance.getData(true);
        document.getElementById('cropX').value = Math.max(0, Math.round(data.x));
        document.getElementById('cropY').value = Math.max(0, Math.round(data.y));
        document.getElementById('cropW').value = Math.round(data.width);
        document.getElementById('cropH').value = Math.round(data.height);

        const canvas = cropperInstance.getCroppedCanvas({ width: 400, height: 400 });
        if (canvas && previewImg) previewImg.src = canvas.toDataURL('image/png');

        cropperModal.classList.add('hidden');
        cropperInstance.destroy();
        cropperInstance = null;
        avatarForm.submit();
    };

    </script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        // Notyf alerts
        document.addEventListener('DOMContentLoaded', () => {
            const notyf = new Notyf({
                duration: 4000,
                position: { x: 'right', y: 'top' },
                dismissible: true
            });
            @if (session('status'))
                notyf.success(@json(session('status')));
            @endif
            @if (session('success'))
                notyf.success(@json(session('success')));
            @endif
            @if (session('error'))
                notyf.error(@json(session('error')));
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    notyf.error(@json($error));
                @endforeach
            @endif
        });
    </script>
</html>
