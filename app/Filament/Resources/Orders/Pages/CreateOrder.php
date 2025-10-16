<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\OrderItem;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected array $orderItemsData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $orderItemsData = $data['orderItems'] ?? [];
        unset($data['orderItems']);

        $this->orderItemsData = $orderItemsData;

        // Set user_id to current authenticated user
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function afterCreate(): void
    {
        if (!empty($this->orderItemsData)) {
            foreach ($this->orderItemsData as $item) {
                OrderItem::create([
                    'order_id' => $this->record->id,
                    'dish_id' => $item['dish_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            $this->record->calculateTotal();
        }
    }
}
