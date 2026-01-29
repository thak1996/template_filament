<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Enums\PanelRole; // Importante: Seu Enum
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Administração';

    protected static ?int $navigationSort = 0; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome Completo')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                // SELEÇÃO DE CARGOS COM PROTEÇÃO
                Select::make('roles')
                    ->label('Cargo / Função')
                    ->relationship('roles', 'name', modifyQueryUsing: function (Builder $query) {
                        // Se quem está logado NÃO É Super Admin...
                        if (! Auth::user()->hasRole(PanelRole::SUPER_ADMIN->value)) {
                            // ... Esconde o cargo 'Super Admin' da lista de opções.
                            return $query->where('name', '!=', PanelRole::SUPER_ADMIN->value);
                        }
                        return $query;
                    })
                    ->multiple()
                    ->preload()
                    ->searchable(),

                // SENHA COM CRIPTOGRAFIA AUTOMÁTICA
                TextInput::make('password')
                    ->password()
                    ->label('Senha')
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context): bool => $context === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable(),

                // EXIBE OS CARGOS COM AS MESMAS CORES DO ENUM
                TextColumn::make('roles.name')
                    ->label('Cargo')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        PanelRole::SUPER_ADMIN->value => 'danger',
                        PanelRole::ADMIN->value => 'warning',
                        PanelRole::USER->value => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->label('Criado em')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Opcional: Esconder delete se o usuário alvo for Super Admin
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
