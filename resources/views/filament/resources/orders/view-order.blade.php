<div class="space-y-6">
    {{-- შეკვეთის ინფორმაცია --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">შეკვეთის ინფორმაცია</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">მაგიდა</span>
                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                        {{ $order->table->number }}
                    </span>
                </p>
            </div>

            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">სტატუსი</span>
                <p class="mt-1 text-sm">
                    @php
                        $statusColors = [
                            'pending' => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200',
                            'confirmed' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
                            'preparing' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                            'ready' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                            'served' => 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200',
                            'completed' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                            'cancelled' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200',
                        ];
                        $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $colorClass }}">
                        {{ \App\Models\Order::getStatuses()[$order->status] ?? $order->status }}
                    </span>
                </p>
            </div>

            @if($order->user)
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">მომსახურე</span>
                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->user->name }}</p>
            </div>
            @endif

            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">შექმნის დრო</span>
                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>

            @if($order->notes)
            <div class="md:col-span-2">
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">შენიშვნები</span>
                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- კერძები --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">კერძები</h3>

        @if($order->items->isEmpty())
            <p class="text-sm text-gray-500">კერძები არ არის დამატებული</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                კერძი
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                რაოდენობა
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                ფასი
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                ჯამი
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                შენიშვნა
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($order->items as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item->dish->name }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-center text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-right">
                                    {{ number_format($item->price, 2) }} ₾
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100 text-right">
                                    {{ number_format($item->subtotal, 2) }} ₾
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->notes ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-right text-base font-semibold text-gray-900 dark:text-gray-100">
                                სულ:
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-base font-bold text-green-600 dark:text-green-400 text-right">
                                {{ number_format($order->total_amount, 2) }} ₾
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</div>
