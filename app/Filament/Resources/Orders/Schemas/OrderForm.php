<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('table_id')
                    ->label('მაგიდა')
                    ->options(Table::where('is_active', true)->pluck('number', 'id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),

                Select::make('status')
                    ->label('სტატუსი')
                    ->options(Order::getStatuses())
                    ->required()
                    ->default(Order::STATUS_PENDING)
                    ->native(false),

                Textarea::make('notes')
                    ->label('შენიშვნები')
                    ->rows(2)
                    ->maxLength(500),

                Repeater::make('orderItems')
                    ->label('კერძები')
                    ->schema([
                        Select::make('dish_id')
                            ->label('კერძი')
                            ->options(Dish::where('is_available', true)->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $dish = Dish::find($state);
                                    $set('price', $dish?->price);
                                }
                            })
                            ->native(false),

                        TextInput::make('quantity')
                            ->label('რაოდენობა')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->step(1),

                        TextInput::make('price')
                            ->label('ფასი')
                            ->required()
                            ->numeric()
                            ->prefix('₾')
                            ->step(0.01)
                            ->disabled()
                            ->dehydrated(),

                        Textarea::make('notes')
                            ->label('შენიშვნა')
                            ->rows(1)
                            ->maxLength(255)
                            ->placeholder('მაგ: უმარილოდ, დამატებითი სოუსი'),
                    ])
                    ->columns(4)
                    ->addActionLabel('კერძის დამატება')
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string =>
                        $state['dish_id']
                            ? Dish::find($state['dish_id'])?->name
                            : null
                    )
                    ->required()
                    ->minItems(1),
            ]);
    }
}
