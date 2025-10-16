<?php

namespace App\Filament\Resources\Ingredients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IngredientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                ->label('დასახელება')
                    ->required(),
                TextInput::make('unit')
                ->label('ერთეული')
                    ->required(),
            ]);
    }
}
