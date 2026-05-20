<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Productos';
    protected static ?string $modelLabel = 'Producto';
    protected static ?string $pluralModelLabel = 'Productos';
    protected static ?string $navigationGroup = 'Gestión';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Nombre')->required(),
            Forms\Components\TextInput::make('brand')->label('Marca')->required(),
            Forms\Components\TextInput::make('price')->label('Precio (€)')->required(),
            Forms\Components\Select::make('category')->label('Categoría')
                ->options(['Cabello' => 'Cabello', 'Barba' => 'Barba'])->required(),
            Forms\Components\TextInput::make('stock')->label('Stock')->default(0),
            Forms\Components\TextInput::make('image')->label('URL de imagen')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('brand')->label('Marca')->searchable(),
                Tables\Columns\TextColumn::make('category')->label('Categoría'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 2, ',', '.') . ' €')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')->label('Stock')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->label('Categoría')
                    ->options(['Cabello' => 'Cabello', 'Barba' => 'Barba']),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
