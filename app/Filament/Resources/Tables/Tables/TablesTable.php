<?php

namespace App\Filament\Resources\Tables\Tables;

use App\Models\Table as TableModel;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TablesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->label('ნომერი')
                    ->searchable()
                    ->sortable()
                    ->size('lg')
                    ->weight('bold'),

                TextColumn::make('capacity')
                    ->label('ადგილები')
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->suffix(' ადგილი'),

                TextColumn::make('status')
                    ->label('სტატუსი')
                    ->badge()
                    ->formatStateUsing(fn ($state) => TableModel::getStatuses()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        TableModel::STATUS_AVAILABLE => 'success',
                        TableModel::STATUS_OCCUPIED => 'danger',
                        TableModel::STATUS_RESERVED => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('location')
                    ->label('ადგილმდებარეობა')
                    ->formatStateUsing(fn ($state) => TableModel::getLocations()[$state] ?? $state)
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('აქტიური')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('შექმნის თარიღი')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('სტატუსი')
                    ->options(TableModel::getStatuses())
                    ->native(false),

                SelectFilter::make('location')
                    ->label('ადგილმდებარეობა')
                    ->options(TableModel::getLocations())
                    ->native(false),

                SelectFilter::make('is_active')
                    ->label('აქტიურია')
                    ->options([
                        '1' => 'აქტიური',
                        '0' => 'არააქტიური',
                    ])
                    ->native(false),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('number')
            ->striped();
    }
}
