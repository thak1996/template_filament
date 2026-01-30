<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Enums\PanelRole;
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

    protected static ?int $navigationSort = 0;

    public static function getModelLabel(): string
    {
        return __('resources.users.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.users.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.users.navigation');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('permissions.settings_view');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label(__('resources.users.form_email_label'))
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Select::make('roles')
                    ->label(__('resources.users.form_roles_label'))
                    ->relationship('roles', 'name', modifyQueryUsing: function (Builder $query) {
                        if (! Auth::user()->hasRole(PanelRole::SUPER_ADMIN->value)) {
                            return $query->where('name', '!=', PanelRole::SUPER_ADMIN->value);
                        }
                        return $query;
                    })
                    ->getOptionLabelFromRecordUsing(
                        fn($record) =>
                        PanelRole::tryFrom($record->name)?->getLabel() ?? $record->name
                    )
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();
                $superAdminRole = PanelRole::SUPER_ADMIN->value;
                if (! $user->hasRole($superAdminRole)) {
                    return $query->whereDoesntHave('roles', function ($q) use ($superAdminRole) {
                        $q->where('name', $superAdminRole);
                    });
                }
                return $query;
            })
            ->columns([
                TextColumn::make('name')
                    ->label(__('resources.users.table_name_label'))
                    ->searchable(),

                TextColumn::make('roles.name')
                    ->label(__('resources.users.table_roles_label'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        PanelRole::SUPER_ADMIN->value => 'danger',
                        PanelRole::ADMIN->value => 'warning',
                        PanelRole::USER->value => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => PanelRole::tryFrom($state)?->getLabelUsersTable() ?? $state)
                    ->searchable(),


                TextColumn::make('email')
                    ->label(__('resources.users.table_email_label'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(function (User $record) {
                        if ($record->id === Auth::id()) {
                            return true;
                        }
                        if ($record->id === 1) {
                            return true;
                        }
                        return false;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function (Tables\Actions\DeleteBulkAction $action, \Illuminate\Database\Eloquent\Collection $records) {
                            $records = $records->reject(fn($user) => $user->id === Auth::id());
                            $records->each->delete();
                            \Filament\Notifications\Notification::make()
                                ->title(__('resources.users.records_deleted'))
                                ->success()
                                ->send();
                        }),
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
