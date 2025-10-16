<?php

namespace App\Filament\Resources\Dishes\Schemas;

use App\Models\Ingredient;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DishForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('დასახელება')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('აღწერა')
                    ->rows(3)
                    ->maxLength(1000),

                TextInput::make('price')
                    ->label('ფასი')
                    ->required()
                    ->numeric()
                    ->prefix('₾')
                    ->step(0.01)
                    ->minValue(0),

                TextInput::make('category')
                    ->label('კატეგორია')
                    ->maxLength(255)
                    ->placeholder('მაგ: ცხელი კერძები, დესერტები, სალათები'),

                Checkbox::make('is_available')
                    ->label('ხელმისაწვდომია')
                    ->default(true),

                Repeater::make('ingredientsPivot')
                    ->label('ინგრედიენტები')
                    ->schema([
                        Select::make('ingredient_id')
                            ->label('ინგრედიენტი')
                            ->options(Ingredient::all()->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $ingredient = Ingredient::find($state);
                                    $set('unit', $ingredient?->unit);
                                }
                            }),

                        TextInput::make('quantity')
                            ->label('რაოდენობა')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->required(),

                        TextInput::make('unit')
                            ->label('ერთეული')
                            ->disabled()
                            ->dehydrated()
                            ->placeholder('აირჩიეთ ინგრედიენტი'),
                    ])
                    ->columns(3)
                    ->addActionLabel('ინგრედიენტის დამატება')
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string =>
                        $state['ingredient_id']
                            ? Ingredient::find($state['ingredient_id'])?->name
                            : null
                    ),
            ]);
    }
}
