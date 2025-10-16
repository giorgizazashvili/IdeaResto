<?php

namespace App\Filament\Resources\Dishes\Pages;

use App\Filament\Resources\Dishes\DishResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDish extends EditRecord
{
    protected static string $resource = DishResource::class;

    protected array $ingredientsPivotData = [];

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['ingredientsPivot'] = $this->record->ingredients->map(function ($ingredient) {
            return [
                'ingredient_id' => $ingredient->id,
                'quantity' => $ingredient->pivot->quantity,
                'unit' => $ingredient->pivot->unit,
            ];
        })->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $ingredientsPivot = $data['ingredientsPivot'] ?? [];
        unset($data['ingredientsPivot']);

        $this->ingredientsPivotData = $ingredientsPivot;

        return $data;
    }

    protected function afterSave(): void
    {
        if (isset($this->ingredientsPivotData)) {
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
