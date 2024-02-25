<?php

namespace App\Filament\Resources;

use App\Enums\Currency;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('farmer_id')
                            ->label('Farmer')
                            ->required()
                            ->relationship('farmer', 'name'),

                        Repeater::make('orderItems')
                            ->relationship()
                            ->schema([
                                Section::make()
                                    ->columns(3)
                                    ->schema(self::orderItemsSchema())
                            ]),
                        TextInput::make('total'),
                        Select::make('currency')
                            ->options(Currency::class),
                        Select::make('status')
                            ->options(OrderStatus::class),
                        Placeholder::make('paymentRecord.status')
                            ->label('Payment status')
                            ->content(function (Order $record) {
                                return $record->paymentRecord->status->getLabel();
                            }),
                    ])
            ]);
    }

    private static function orderItemsSchema(): array
    {
        return [
            Select::make('product_id')
                ->label('Product')
                ->relationship('product', 'name')
                ->live()
                ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                    $product = Product::find($state);

                    $set('unit_price', $product->unit_price ?? 0);
                    $set('currency', $product->currency ?? Currency::getDefault());
                    $set('unit_id', $product->unit_id ?? null);
                    $set(
                        'total_price',
                        (int) $get('unit_price') * (int) $state
                    );
                }),
            TextInput::make('quantity')
                ->required()
                ->numeric()
                ->live()
                ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                    $set(
                        'total_price',
                        (int) $get('unit_price') * (int) $state
                    );
                }),
            TextInput::make('unit_price')
                ->readOnly(),
            TextInput::make('currency')
                ->readOnly(),
            TextInput::make('total_price')
                ->readOnly(),
            Select::make('unit_id')
                ->label('Unit')
                ->relationship('unit', 'symbol')
                ->disabled()
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Sn')
                    ->rowIndex(),
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('farmer.name')
                    ->searchable(),
                TextColumn::make('total')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('currency'),
                TextColumn::make('status')
                    ->sortable(),
                TextColumn::make('paymentRecord.status')
                    ->label('Payment status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
