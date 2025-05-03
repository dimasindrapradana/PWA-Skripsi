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
    protected static ?string $navigationGroup = 'Manajemen Quiz';
    protected static ?string $label = 'List Pertanyaan';

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
            

            Forms\Components\Repeater::make('images')
                ->relationship()
                ->label('Gambar (opsional)')
                ->schema([
                    Forms\Components\FileUpload::make('image_url')
                        ->image()
                        ->directory('images')
                        ->nullable(),
                    Forms\Components\TextInput::make('description')->label("Nama Gambar")  
                    ->required()
                ])
                ->columns(1),

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

                Forms\Components\Repeater::make('videos')
                    ->relationship()
                    ->label('Video (opsional)')
                 ->schema([
                Forms\Components\FileUpload::make('video_url')
                    ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mkv'])
                    ->nullable()
                    ->label('URL Video')
                    ->directory('videos'),
    ])
    ->columns(1)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('test.title')->label('Kuis')
            ->searchable(),
            Tables\Columns\TextColumn::make('question_text')->limit(50)->label('Soal'),
            Tables\Columns\TextColumn::make('question_type')->label('Tipe'),
            Tables\Columns\TextColumn::make('options_count')->counts('options')->label('Jumlah Opsi'),
            Tables\Columns\TextColumn::make('images_count')->counts('images')->label('Jumlah Gambar'),
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
            \App\Filament\Resources\QuestionResource\RelationManagers\OptionsRelationManager::class,
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
