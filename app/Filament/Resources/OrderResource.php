<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Pedidos';
    protected static ?string $modelLabel = 'Pedido';
    protected static ?string $pluralModelLabel = 'Pedidos';
    protected static ?string $navigationGroup = 'Gestión';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Cliente')->schema([
                Forms\Components\TextInput::make('client_name')->label('Nombre')->required(),
                Forms\Components\TextInput::make('client_email')->label('Email')->email()->required(),
                Forms\Components\TextInput::make('client_phone')->label('Teléfono')->required(),
            ])->columns(3),

            Forms\Components\Section::make('Envío')->schema([
                Forms\Components\TextInput::make('address')->label('Dirección')->required(),
                Forms\Components\TextInput::make('city')->label('Ciudad')->required(),
                Forms\Components\TextInput::make('postal_code')->label('Código postal')->required(),
            ])->columns(3),

            Forms\Components\Section::make('Pago')->schema([
                Forms\Components\TextInput::make('payment_last4')->label('Últimos 4 dígitos tarjeta'),
                Forms\Components\TextInput::make('total')->label('Total (€)'),
                Forms\Components\Select::make('status')->label('Estado')
                    ->options(['paid' => 'Pagado', 'shipped' => 'Enviado', 'cancelled' => 'Cancelado'])
                    ->required(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('client_name')->label('Cliente')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('client_email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 2, ',', '.') . ' €')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_last4')
                    ->label('Tarjeta')
                    ->formatStateUsing(fn ($state) => '•••• ' . $state),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'paid'      => 'Pagado',
                        'shipped'   => 'Enviado',
                        'cancelled' => 'Cancelado',
                        default     => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'paid'      => 'success',
                        'shipped'   => 'info',
                        'cancelled' => 'danger',
                        default     => 'warning',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->formatStateUsing(fn ($state) => $state ? date('d/m/Y H:i', strtotime($state)) : '-')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Estado')
                    ->options(['paid' => 'Pagado', 'shipped' => 'Enviado', 'cancelled' => 'Cancelado']),
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
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
