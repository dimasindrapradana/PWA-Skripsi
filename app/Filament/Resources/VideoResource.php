<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Filament\Resources\VideoResource\RelationManagers;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';
    protected static ?string $navigationGroup = 'Media';
    protected static ?string $label = 'List Video';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
                // Forms\Components\TextInput::make('video_url')
                // ->url()
                // ->placeholder("Masukan link video...")
                // ->required(),
                // Forms\Components\TextInput::make('description')->label("Judul Video") 
                // ->placeholder("Masukan judul video ... ") 
                // ->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

            // Tables\Columns\TextColumn::make('videoable.title')
            //     ->label('Materi')
            //     ->sortable()
            //     ->searchable(),
            
            Tables\Columns\Textcolumn::make('description')
            ->label("Judul Video")   
            ->searchable(),
            
            Tables\Columns\TextColumn::make('video_url')
                ->label('Video URL')
                ->copyable()
                ->wrap(),
               
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
