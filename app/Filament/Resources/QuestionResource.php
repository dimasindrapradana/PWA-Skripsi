<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Quiz';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('test_id')
                ->relationship('test', 'title')
                ->required()
                ->label('Judul Kuis'),

            Forms\Components\Textarea::make('question_text')
                ->required()
                ->label('Pertanyaan'),

            Forms\Components\TextInput::make('question_type')
                ->default('multiple_choice')
                ->disabled()
                ->label('Tipe Pertanyaan'),

            Forms\Components\Repeater::make('options')
                ->relationship()
                ->label('Pilihan Jawaban')
                ->schema([
                    Forms\Components\TextInput::make('option_text')
                        ->required()
                        ->label('Teks Pilihan'),

                    Forms\Components\Toggle::make('is_correct')
                        ->label('Benar?'),
                ])
                ->columns(2)
                ->defaultItems(4)
                ->minItems(2)
                ->maxItems(6),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('test.title')->label('Kuis'),
            Tables\Columns\TextColumn::make('question_text')->limit(50)->label('Soal'),
            Tables\Columns\TextColumn::make('question_type')->label('Tipe'),
            Tables\Columns\TextColumn::make('options_count')->counts('options')->label('Jumlah Opsi'),
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
