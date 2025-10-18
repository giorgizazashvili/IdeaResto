<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('table.number')
                    ->label('მაგიდა')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('items_count')
                    ->label('კერძები')
                    ->counts('items')
                    ->badge()
                    ->color('gray')
                    ->suffix(' ცალი'),

                TextColumn::make('total_amount')
                    ->label('ჯამი')
                    ->money('GEL')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('status')
                    ->label('სტატუსი')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Order::getStatuses()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        Order::STATUS_PENDING => 'gray',
                        Order::STATUS_CONFIRMED => 'info',
                        Order::STATUS_PREPARING => 'warning',
                        Order::STATUS_READY => 'success',
                        Order::STATUS_SERVED => 'primary',
                        Order::STATUS_COMPLETED => 'success',
                        Order::STATUS_CANCELLED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label('გადახდა')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Order::getPaymentStatuses()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        Order::PAYMENT_PAID => 'success',
                        Order::PAYMENT_UNPAID => 'danger',
                        Order::PAYMENT_PARTIAL => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('მომსახურე')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('შექმნის დრო')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('სტატუსი')
                    ->options(Order::getStatuses())
                    ->native(false),

                SelectFilter::make('payment_status')
                    ->label('გადახდის სტატუსი')
                    ->options(Order::getPaymentStatuses())
                    ->native(false),

                SelectFilter::make('table_id')
                    ->label('მაგიდა')
                    ->relationship('table', 'number')
                    ->searchable()
                    ->preload()
                    ->native(false),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                \Filament\Actions\Action::make('receipt')
                    ->label('ანგარიში')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    ->url(fn ($record) => route('orders.receipt', $record))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('10s');
    }
}
