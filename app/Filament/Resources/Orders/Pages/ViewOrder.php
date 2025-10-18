<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\View as ViewComponent;
use Filament\Schemas\Schema;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('receipt')
                ->label('ანგარიშის ნახვა')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->url(fn ($record) => route('orders.receipt', $record))
                ->openUrlInNewTab(),
            EditAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                ViewComponent::make('filament.resources.orders.view-order')
                    ->viewData(fn ($record) => ['order' => $record]),
            ]);
    }
}
