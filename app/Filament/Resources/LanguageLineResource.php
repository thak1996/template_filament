<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguageLineResource\Pages;
use App\Filament\Resources\LanguageLineResource\RelationManagers;
use Spatie\TranslationLoader\LanguageLine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class LanguageLineResource extends Resource
{
    // Lembre-se de importar o Model do pacote Spatie lá em cima
    protected static ?string $model = LanguageLine::class;

    protected static ?string $navigationIcon = 'heroicon-o-language'; // Ícone mais adequado
    protected static ?string $navigationLabel = 'Traduções';
    protected static ?string $navigationGroup = 'Administração';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identificação da Chave')
                    ->description('Defina onde e qual texto será traduzido. Cuidado ao alterar isso, pois o código depende dessas chaves.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('group')
                                ->label('Grupo')
                                ->placeholder('ex: permissions, roles, validation')
                                ->required()
                                ->maxLength(255)
                                ->disabledOn('edit'),

                            TextInput::make('key')
                                ->label('Chave (Código)')
                                ->placeholder('ex: users_create, welcome_message')
                                ->required()
                                ->disabledOn('edit'),
                        ]),
                    ]),

                Section::make('Conteúdo Traduzido')
                    ->description('Os textos que aparecerão para o usuário final.')
                    ->schema([
                        TextInput::make('text.pt_BR')
                            ->label('Português (Brasil)')
                            ->required(),

                        TextInput::make('text.en')
                            ->label('Inglês (English)'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group')
                    ->label('Grupo')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('key')
                    ->label('Chave')
                    ->fontFamily('mono')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('text.pt_BR')
                    ->label('Tradução (PT-BR)')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('text.en')
                    ->label('Tradução (EN)')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Filtrar por Grupo')
                    ->options(fn() => LanguageLine::query()->pluck('group', 'group')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLanguageLines::route('/'),
            'create' => Pages\CreateLanguageLine::route('/create'),
            'edit' => Pages\EditLanguageLine::route('/{record}/edit'),
        ];
    }
}
