<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\OrderItem;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected array $orderItemsData = [];

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load items with dish relationship
        $this->record->load('items.dish');

        $data['orderItems'] = $this->record->items->map(function ($item) {
            return [
                'dish_id' => $item->dish_id,
                'quantity' => $item->quantity,
                'price' => (float) $item->price,
                'notes' => $item->notes,
            ];
        })->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $orderItemsData = $data['orderItems'] ?? [];
        unset($data['orderItems']);

        $this->orderItemsData = $orderItemsData;

        return $data;
    }

    protected function afterSave(): void
    {
        if (isset($this->orderItemsData)) {
            // Delete existing items
            $this->record->items()->delete();

            // Create new items
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
