<?php

namespace App\Filament\Resources\TestResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'Questions';

    protected static ?string $recordTitleAttribute = 'question_text';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('question_text')->required()
                    ->label('Pertanyaan')
                    ->placeholder("Masukan pertanyaan ... "),
                Forms\Components\Repeater::make('images')
                ->relationship('images')
                ->label('Gambar (opsional)')
                ->schema([
                    Forms\Components\FileUpload::make('image_url')
                        ->image()
                        ->directory('images')
                        ->nullable(),
                    Forms\Components\TextInput::make('description')->label("Nama Gambar")  
                        ->placeholder("Masukan nama gambar ... ")
                        ->required()
                ])
                ->columns(1),
                Forms\Components\Repeater::make('options')
                    ->relationship()
                    ->label('Pilihan Jawaban')
                    ->schema([
                        Forms\Components\TextInput::make('option_text')->required()->label('Opsi'),
                        Forms\Components\Toggle::make('is_correct')->label('Benar?'),
                    ])
                    ->columns(2)
                    ->defaultItems(4)
                    ->minItems(2)
                    ->maxItems(6),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question_text')
            ->columns([
                Tables\Columns\TextColumn::make('question_text')->limit(50)->label('Pertanyaan'),
                Tables\Columns\TextColumn::make('options_count')->counts('options')->label('Jumlah Opsi'),
                Tables\Columns\TextColumn::make('images_count')->counts('images')->label('Jumlah Gambar'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
