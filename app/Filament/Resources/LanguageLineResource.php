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

    protected static ?string $navigationIcon = 'heroicon-o-language';
    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('language_line_resource.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('language_line_resource.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('language_line_resource.key_identification_title'))
                    ->description(__('language_line_resource.key_identification_description'))
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('group')
                                ->label(__('language_line_resource.key_identification_group_label'))
                                ->placeholder(__('language_line_resource.key_identification_group_placeholder'))
                                ->required()
                                ->maxLength(255)
                                ->disabledOn('edit'),

                            TextInput::make('key')
                                ->label(__('language_line_resource.key_identification_key_label'))
                                ->placeholder(__('language_line_resource.key_identification_key_placeholder'))
                                ->required()
                                ->disabledOn('edit'),
                        ]),
                    ]),

                Section::make(__('language_line_resource.content_title'))
                    ->description(__('language_line_resource.content_description'))
                    ->schema([
                        TextInput::make('text.pt_BR')
                            ->label(__('language_line_resource.content_pt_br_label'))
                            ->required(),

                        TextInput::make('text.en')
                            ->label(__('language_line_resource.content_en_label')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group')
                    ->label(__('language_line_resource.table_group_label'))
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('key')
                    ->label(__('language_line_resource.table_key_label'))
                    ->fontFamily('mono')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('text.pt_BR')
                    ->label(__('language_line_resource.table_pt_br_label'))
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('text.en')
                    ->label(__('language_line_resource.table_en_label'))
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label(__('language_line_resource.filter_group_label'))
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
