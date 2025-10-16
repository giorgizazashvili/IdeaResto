@php
    $elapsed = now()->diffInMinutes($order->created_at);
@endphp

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl hover:shadow-2xl transition-all border-l-8 {{ $borderColor }} overflow-hidden">
    {{-- Header --}}
    <div class="p-5 bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 border-b-2 border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-3">
            <div class="text-3xl font-black text-gray-900 dark:text-gray-100">
                🪑 {{ $order->table->number }}
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">#{{ $order->id }}</div>
                <div class="text-lg font-bold px-4 py-2 rounded-full shadow-lg
                    @if($elapsed > 15) bg-red-600 text-white animate-pulse-slow
                    @elseif($elapsed > 10) bg-yellow-500 text-white
                    @else bg-green-500 text-white
                    @endif
                ">
                    {{ $elapsed }} წთ
                </div>
            </div>
        </div>
        <div class="text-sm text-gray-600 dark:text-gray-400">
            ⏰ {{ $order->created_at->format('H:i') }}
        </div>
    </div>

    {{-- კერძები --}}
    <div class="p-5 space-y-3 max-h-80 overflow-y-auto">
        @foreach($order->items as $item)
            <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg p-4 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-400 transition-colors">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100">
                            {{ $item->dish->name }}
                        </div>
                        @if($item->notes)
                            <div class="text-sm text-red-600 dark:text-red-400 font-bold bg-red-100 dark:bg-red-900/30 px-3 py-2 rounded-lg mt-2 animate-pulse">
                                ⚠️ {{ $item->notes }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-xl">
                            <span class="text-3xl font-black text-white">
                                {{ $item->quantity }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ღილაკები --}}
    <div class="p-5 bg-gray-50 dark:bg-gray-900">
        @if($order->status === 'pending')
            <button
                onclick="updateStatus({{ $order->id }}, 'confirmed')"
                class="w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-2xl transition-all transform hover:scale-105"
            >
                ✓ დადასტურება →
            </button>
        @endif

        @if($order->status === 'confirmed')
            <button
                onclick="updateStatus({{ $order->id }}, 'preparing')"
                class="w-full px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-2xl transition-all transform hover:scale-105"
            >
                🍳 დაწყება →
            </button>
        @endif

        @if($order->status === 'preparing')
            <button
                onclick="updateStatus({{ $order->id }}, 'ready')"
                class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-2xl transition-all transform hover:scale-105"
            >
                ✅ მზადაა →
            </button>
        @endif

        @if($order->status === 'ready')
            <button
                onclick="updateStatus({{ $order->id }}, 'served')"
                class="w-full px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-2xl transition-all transform hover:scale-105"
            >
                🚶 მიტანა →
            </button>
        @endif
    </div>
</div>
