<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>სამზარეულოს ეკრანი - IdeaResto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse-slow {
            animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        body {
            overflow-x: hidden;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div id="app" class="min-h-screen p-4">
        {{-- Header --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white">🍳 სამზარეულო</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1" id="current-time"></p>
                </div>
                <div class="flex gap-3">
                    <button onclick="location.reload()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg transition-all">
                        🔄 განახლება
                    </button>
                    <button onclick="toggleFullscreen()" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-bold shadow-lg transition-all">
                        ⛶ Fullscreen
                    </button>
                </div>
            </div>
        </div>

        {{-- სტატისტიკა --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @php
                $pending = $orders->where('status', 'pending');
                $confirmed = $orders->where('status', 'confirmed');
                $preparing = $orders->where('status', 'preparing');
                $ready = $orders->where('status', 'ready');
            @endphp

            <div class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 shadow-lg">
                <div class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">📋 მოლოდინში</div>
                <div class="text-5xl font-black text-gray-900 dark:text-gray-100">{{ $pending->count() }}</div>
            </div>

            <div class="bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-800 dark:to-blue-900 rounded-xl p-6 shadow-lg">
                <div class="text-sm font-semibold text-blue-700 dark:text-blue-300 mb-2">✅ დადასტურებული</div>
                <div class="text-5xl font-black text-blue-900 dark:text-blue-100">{{ $confirmed->count() }}</div>
            </div>

            <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-800 dark:to-yellow-900 rounded-xl p-6 shadow-lg">
                <div class="text-sm font-semibold text-yellow-700 dark:text-yellow-300 mb-2">🍳 მზადდება</div>
                <div class="text-5xl font-black text-yellow-900 dark:text-yellow-100">{{ $preparing->count() }}</div>
            </div>

            <div class="bg-gradient-to-br from-green-100 to-green-200 dark:from-green-800 dark:to-green-900 rounded-xl p-6 shadow-lg">
                <div class="text-sm font-semibold text-green-700 dark:text-green-300 mb-2">✨ მზადაა</div>
                <div class="text-5xl font-black text-green-900 dark:text-green-100">{{ $ready->count() }}</div>
            </div>
        </div>

        {{-- კანბანი --}}
        @if($orders->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-20 text-center">
                <div class="text-9xl mb-6">🎉</div>
                <div class="text-4xl font-bold text-gray-600 dark:text-gray-400 mb-4">ყველა შეკვეთა დასრულებულია!</div>
                <div class="text-xl text-gray-500 dark:text-gray-500">დროა დასვენება ☕</div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                {{-- სვეტი 1: მოლოდინში --}}
                <div class="flex flex-col">
                    <div class="bg-gradient-to-r from-gray-600 to-gray-700 rounded-t-xl p-5 shadow-xl">
                        <div class="flex items-center justify-between text-white">
                            <div class="flex items-center gap-3">
                                <span class="text-3xl">📋</span>
                                <span class="font-bold text-xl">მოლოდინში</span>
                            </div>
                            <div class="bg-white/30 px-4 py-2 rounded-full text-lg font-black">
                                {{ $pending->count() }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-b-xl p-4 space-y-4 min-h-96">
                        @forelse($pending as $order)
                            @include('kitchen.partials.order-card', ['order' => $order, 'borderColor' => 'border-gray-500'])
                        @empty
                            <div class="text-center py-12 text-gray-400">
                                <div class="text-6xl mb-3">✓</div>
                                <div class="text-lg">ცარიელია</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- სვეტი 2: დადასტურებული --}}
                <div class="flex flex-col">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-xl p-5 shadow-xl">
                        <div class="flex items-center justify-between text-white">
                            <div class="flex items-center gap-3">
                                <span class="text-3xl">✅</span>
                                <span class="font-bold text-xl">დადასტურებული</span>
                            </div>
                            <div class="bg-white/30 px-4 py-2 rounded-full text-lg font-black">
                                {{ $confirmed->count() }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-950 rounded-b-xl p-4 space-y-4 min-h-96">
                        @forelse($confirmed as $order)
                            @include('kitchen.partials.order-card', ['order' => $order, 'borderColor' => 'border-blue-500'])
                        @empty
                            <div class="text-center py-12 text-blue-300">
                                <div class="text-6xl mb-3">✓</div>
                                <div class="text-lg">ცარიელია</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- სვეტი 3: მზადდება --}}
                <div class="flex flex-col">
                    <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 rounded-t-xl p-5 shadow-xl">
                        <div class="flex items-center justify-between text-white">
                            <div class="flex items-center gap-3">
                                <span class="text-3xl">🍳</span>
                                <span class="font-bold text-xl">მზადდება</span>
                            </div>
                            <div class="bg-white/30 px-4 py-2 rounded-full text-lg font-black">
                                {{ $preparing->count() }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-yellow-50 dark:bg-yellow-950 rounded-b-xl p-4 space-y-4 min-h-96">
                        @forelse($preparing as $order)
                            @include('kitchen.partials.order-card', ['order' => $order, 'borderColor' => 'border-yellow-500'])
                        @empty
                            <div class="text-center py-12 text-yellow-400">
                                <div class="text-6xl mb-3">✓</div>
                                <div class="text-lg">ცარიელია</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- სვეტი 4: მზადაა --}}
                <div class="flex flex-col">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-t-xl p-5 shadow-xl">
                        <div class="flex items-center justify-between text-white">
                            <div class="flex items-center gap-3">
                                <span class="text-3xl">✨</span>
                                <span class="font-bold text-xl">მზადაა</span>
                            </div>
                            <div class="bg-white/30 px-4 py-2 rounded-full text-lg font-black">
                                {{ $ready->count() }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 dark:bg-green-950 rounded-b-xl p-4 space-y-4 min-h-96">
                        @forelse($ready as $order)
                            @include('kitchen.partials.order-card', ['order' => $order, 'borderColor' => 'border-green-500'])
                        @empty
                            <div class="text-center py-12 text-green-300">
                                <div class="text-6xl mb-3">✓</div>
                                <div class="text-lg">ცარიელია</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        // დროის განახლება
        function updateTime() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('ka-GE', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const dateStr = now.toLocaleDateString('ka-GE', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('current-time').textContent = `${dateStr}, ${timeStr}`;
        }
        updateTime();
        setInterval(updateTime, 1000);

        // Fullscreen
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        }

        // Auto refresh ყოველ 15 წამში
        setTimeout(() => location.reload(), 15000);

        // სტატუსის განახლება
        async function updateStatus(orderId, status) {
            try {
                const response = await fetch(`/kitchen/update-status/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status })
                });

                if (response.ok) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
                alert('შეცდომა სტატუსის განახლებისას');
            }
        }
    </script>
</body>
</html>
