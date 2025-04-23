<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OptionResource\Pages;
use App\Filament\Resources\OptionResource\RelationManagers;
use App\Models\Option;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OptionResource extends Resource
{
    protected static ?string $model = Option::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Quiz';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('question_id')
                    ->relationship('question', 'question_text')
                    ->required(),

                Forms\Components\TextInput::make('option_text')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Toggle::make('is_correct')
                    ->label('Jawaban Benar')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('option_text')
                ->label('Pilihan Jawaban')
                ->limit(50), // Membatasi panjang teks yang ditampilkan

                Tables\Columns\IconColumn::make('is_correct')
                ->label('Benar?')
                ->boolean(), 

                Tables\Columns\TextColumn::make('question.question_text')
                ->label('Pertanyaan') // Menampilkan teks pertanyaan yang terkait dengan pilihan jawaban
                ->limit(50), // Membatasi panjang teks pertanyaan yang ditampilkan
            ])
            ->filters([
                //
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
            'index' => Pages\ListOptions::route('/'),
            'create' => Pages\CreateOption::route('/create'),
            'edit' => Pages\EditOption::route('/{record}/edit'),
        ];
    }
}
