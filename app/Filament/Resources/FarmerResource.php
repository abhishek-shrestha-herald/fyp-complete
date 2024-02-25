<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FarmerResource\Pages;
use App\Filament\Resources\FarmerResource\RelationManagers;
use App\Models\Farmer;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FarmerResource extends Resource
{
    protected static ?string $model = Farmer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('mobile_number')
                            ->required(),
                        TextInput::make('password')
                            ->hiddenOn('edit')
                            ->password(),
                        Toggle::make('is_active')
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Sn')
                    ->rowIndex(),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('mobile_number'),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('email_verified_at')
                    ->label("Email Verified")
                    ->boolean(),
                TextColumn::make('last_login_at'),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFarmers::route('/'),
            'create' => Pages\CreateFarmer::route('/create'),
            'view' => Pages\ViewFarmer::route('/{record}'),
            'edit' => Pages\EditFarmer::route('/{record}/edit'),
        ];
    }
}
