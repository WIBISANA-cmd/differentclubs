<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>differentclubs | Customers</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-slate-500">Admin / Customers</p>
                <h1 class="text-2xl font-bold text-slate-900 mt-1">Customers (Client Role)</h1>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Back to Dashboard</a>
        </div>

        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="text-sm text-slate-500">Total: {{ $customers->total() }} users</div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $customer->name }}</td>
                                <td class="px-6 py-4">{{ $customer->email }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $customer->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-6 text-center text-slate-500">Belum ada pelanggan dengan role client.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</body>
</html>
