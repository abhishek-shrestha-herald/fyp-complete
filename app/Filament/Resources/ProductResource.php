<?php

namespace App\Filament\Resources;

use App\Enums\Currency;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('category_id')
                            ->label('Category')
                            ->required()
                            ->relationship('category', 'name'),
                        TextInput::make('name')
                            ->required(),
                        RichEditor::make('description')
                            ->required(),
                        TextInput::make('unit_price')
                            ->required()
                            ->numeric(),
                        Select::make('currency')
                            ->required()
                            ->options(Currency::class),
                        TextInput::make('available_quantity')
                            ->required()
                            ->numeric(),
                        Select::make('unit_id')
                            ->label('Unit')
                            ->required()
                            ->relationship('unit', 'symbol'),
                        CuratorPicker::make('cover_image_id')
                            ->label('Cover Image'),
                        CuratorPicker::make('images')
                            ->multiple()
                            ->relationship('images', 'id')
                            ->orderColumn('order'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    CuratorColumn::make('coverImage')
                        ->ring(2)
                        ->circular()
                        ->grow(false)
                        ->size('lg'),
                    CuratorColumn::make('images')
                        ->ring(2) // options 0,1,2,4
                        ->overlap(4) // options 0,2,3,4
                        ->limit(3)
                        ->circular(),
                    TextColumn::make('name')
                        ->searchable()
                        ->grow(false)
                        ->words(10)
                        ->alignment(Alignment::Center),
                    TextColumn::make('category.name')
                        ->badge()
                        ->searchable()
                        ->alignment(Alignment::Center),
                    TextColumn::make('unit_price')
                        ->formatStateUsing(function (string $state, Product $record): string {
                            return $record->currency->getLabel() . ' ' . $state;
                        })
                        ->alignment(Alignment::Center),

                    TextColumn::make('available_quantity')
                        ->formatStateUsing(function (string $state, Product $record): string {
                            return 'Remaining: ' . $state;
                        })
                        ->alignment(Alignment::Center),

                ])->alignment(Alignment::Center),

            ])
            ->contentGrid([
                'sm' => 2,
                'md' => 3,
                'lg' => 4
            ])
            ->paginated([10, 24, 48, 96, 'all'])
            ->defaultPaginationPageOption(24)
            ->filters([
                Filter::make('category.name')
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
