<?php

namespace App\Filament\Resources\Dishes\Pages;

use App\Filament\Resources\Dishes\DishResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDish extends CreateRecord
{
    protected static string $resource = DishResource::class;

    protected array $ingredientsPivotData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $ingredientsPivot = $data['ingredientsPivot'] ?? [];
        unset($data['ingredientsPivot']);

        $this->ingredientsPivotData = $ingredientsPivot;

        return $data;
    }

    protected function afterCreate(): void
    {
        if (!empty($this->ingredientsPivotData)) {
            $syncData = [];
            foreach ($this->ingredientsPivotData as $ingredient) {
                $syncData[$ingredient['ingredient_id']] = [
                    'quantity' => $ingredient['quantity'] ?? null,
                    'unit' => $ingredient['unit'] ?? null,
                ];
            }
            $this->record->ingredients()->sync($syncData);
        }
    }
}
