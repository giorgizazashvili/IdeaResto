<?php

namespace App\Filament\Resources\Tables\Schemas;

use App\Models\Table as TableModel;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TableForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('number')
                    ->label('მაგიდის ნომერი')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->placeholder('მაგ: 1, A1, VIP-1'),

                TextInput::make('capacity')
                    ->label('ადგილების რაოდენობა')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(50)
                    ->default(2)
                    ->step(1),

                Select::make('status')
                    ->label('სტატუსი')
                    ->options(TableModel::getStatuses())
                    ->required()
                    ->default(TableModel::STATUS_AVAILABLE)
                    ->native(false),

                Select::make('location')
                    ->label('ადგილმდებარეობა')
                    ->options(TableModel::getLocations())
                    ->required()
                    ->default(TableModel::LOCATION_INDOOR)
                    ->native(false),

                Checkbox::make('is_active')
                    ->label('აქტიურია')
                    ->default(true)
                    ->helperText('გამორთული მაგიდები არ გამოჩნდება შეკვეთების სისტემაში'),
            ]);
    }
}
