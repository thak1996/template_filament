<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Enums\PanelRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Group;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Administração';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identificação')
                    ->description('Defina o nome do cargo.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome do Cargo')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->minLength(2)
                            ->maxLength(255)
                            ->disabled(
                                fn(?Role $record) =>
                                $record && in_array($record->name, array_column(PanelRole::cases(), 'value'))
                            ),
                    ]),

                Section::make('Permissões de Acesso')
                    ->description('Selecione as funcionalidades permitidas para este cargo.')
                    ->schema([
                        Group::make()
                            ->schema(function () {
                                $permissions = Permission::all();

                                $groups = $permissions->groupBy(fn($perm) => Str::before($perm->name, '_'));

                                return $groups->map(fn($permissionsDoGrupo, $nomeDoGrupo) => Section::make(Str::ucfirst($nomeDoGrupo))
                                    ->schema([
                                        CheckboxList::make('permissions_' . $nomeDoGrupo)
                                            ->label('')
                                            ->options($permissionsDoGrupo->pluck('name', 'id'))
                                            ->bulkToggleable()
                                            ->columns(2)
                                            ->gridDirection('row')
                                            ->disabled(
                                                fn($record) =>
                                                $record && $record->name === PanelRole::SUPER_ADMIN->value
                                            )
                                            ->formatStateUsing(function ($record) use ($permissionsDoGrupo) {
                                                if (!$record) return [];
                                                if ($record->name === PanelRole::SUPER_ADMIN->value) {
                                                    return $permissionsDoGrupo->pluck('id')->toArray();
                                                }
                                                return $record->permissions
                                                    ->whereIn('id', $permissionsDoGrupo->pluck('id'))
                                                    ->pluck('id')
                                                    ->toArray();
                                            })
                                            ->dehydrated(false),
                                    ])
                                    ->collapsible()
                                    ->collapsed()
                                    ->compact())->toArray();
                            })
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (! Auth::user()->hasRole(PanelRole::SUPER_ADMIN->value)) {
                    return $query->where('name', '!=', PanelRole::SUPER_ADMIN->value);
                }
                return $query;
            })
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')
                    ->label('Cargo')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        PanelRole::SUPER_ADMIN->value => 'danger',
                        PanelRole::ADMIN->value => 'warning',
                        PanelRole::USER->value => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Permissões')
                    ->badge()
                    ->formatStateUsing(function ($state, Role $record) {
                        if ($record->name === PanelRole::SUPER_ADMIN->value) {
                            return Permission::count();
                        }
                        return $state;
                    })
                    ->color(
                        fn(Role $record) =>
                        $record->name === PanelRole::SUPER_ADMIN->value ? 'success' : 'info'
                    ),

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->label('Criado em')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn(Role $record) => in_array($record->name, array_column(PanelRole::cases(), 'value'))),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
