<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestResource\Pages;
use App\Filament\Resources\TestResource\RelationManagers;
use App\Models\Test;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestResource extends Resource
{
    protected static ?string $model = Test::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Buat Quis';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('material_id')
                ->relationship('material', 'title') // Relasi ke Material
                ->required()
                ->label('Materi'),

            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->label('Judul Kuis'),

            Forms\Components\Textarea::make('description')
                ->nullable()
                ->label('Keterangan'),

            Forms\Components\TextInput::make('time_limit')
                ->nullable()
                ->numeric()
                ->label('Batas Waktu (menit)'),

            
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('material.title')->label('Materi')
                ->searchable(),
                Tables\Columns\TextColumn::make('title')->label('Judul Kuis')
                ->searchable(),
                Tables\Columns\TextColumn::make('description')->limit(50)->label('Deskripsi'),
                Tables\Columns\TextColumn::make('time_limit')->label('Batas Waktu'),
                Tables\Columns\TextColumn::make('questions_count')
                     ->counts('questions')
                     ->label('Jumlah Soal')
                     ->sortable(),
                
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\TestResource\RelationManagers\QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTests::route('/'),
            'create' => Pages\CreateTest::route('/create'),
            'edit' => Pages\EditTest::route('/{record}/edit'),
        ];
    }
}
