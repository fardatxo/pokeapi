<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Citas';
    protected static ?string $modelLabel = 'Cita';
    protected static ?string $pluralModelLabel = 'Citas';
    protected static ?string $navigationGroup = 'Gestión';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Servicio')->schema([
                Forms\Components\TextInput::make('service_name')->label('Servicio')->required(),
                Forms\Components\TextInput::make('service_price')->label('Precio (€)')->required(),
                Forms\Components\TextInput::make('service_duration')->label('Duración (min)')->required(),
            ])->columns(3),

            Forms\Components\Section::make('Fecha y hora')->schema([
                Forms\Components\DatePicker::make('date')->label('Fecha')->required(),
                Forms\Components\TextInput::make('time')->label('Hora')->required(),
                Forms\Components\Select::make('status')->label('Estado')
                    ->options(['pending' => 'Pendiente', 'confirmed' => 'Confirmada', 'cancelled' => 'Cancelada'])
                    ->required(),
            ])->columns(3),

            Forms\Components\Section::make('Datos del cliente')->schema([
                Forms\Components\TextInput::make('client_name')->label('Nombre')->required(),
                Forms\Components\TextInput::make('client_phone')->label('Teléfono')->required(),
                Forms\Components\TextInput::make('client_email')->label('Email')->email()->required(),
                Forms\Components\Textarea::make('notes')->label('Notas')->columnSpanFull(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->formatStateUsing(fn ($state) => $state ? date('d/m/Y', strtotime($state)) : '-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')->label('Hora'),
                Tables\Columns\TextColumn::make('client_name')->label('Cliente')->searchable(),
                Tables\Columns\TextColumn::make('client_phone')->label('Teléfono'),
                Tables\Columns\TextColumn::make('service_name')->label('Servicio')->searchable(),
                Tables\Columns\TextColumn::make('service_price')
                    ->label('Precio')
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 2, ',', '.') . ' €'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending'   => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'cancelled' => 'Cancelada',
                        default     => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        default     => 'warning',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reservada el')
                    ->formatStateUsing(fn ($state) => $state ? date('d/m/Y H:i', strtotime($state)) : '-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options(['pending' => 'Pendiente', 'confirmed' => 'Confirmada', 'cancelled' => 'Cancelada']),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Eliminar seleccionadas'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit'   => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
