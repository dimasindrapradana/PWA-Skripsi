<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Filament\Resources\MaterialResource\RelationManagers;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    
    protected static ?string $label = 'Materi';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name') // Pastikan 'name' adalah nama kolom pada model Category
                ->required()
                ->label('Kategori'),

            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->label('Judul Materi')
                ->placeholder("Masukan judul materi ... "),
                

            Forms\Components\Textarea::make('content')
                ->required()
                ->label('Konten')
                ->placeholder("Masukan isi konten/materi ... "),
                
            Forms\Components\Repeater::make('images')
                ->relationship()
                ->schema([
                    Forms\Components\FileUpload::make('image_url')
                        ->image()
                        ->directory('images')
                        ->nullable(),
                    Forms\Components\TextInput::make('description')->label("Nama Gambar") 
                        ->placeholder("Masukan nama gambar ... ") 
                        ->required()
                ])
                ->columns(2)
                ->label('Gambar (opsional)'),

            Forms\Components\Repeater::make('videos')
                ->relationship()
                ->schema([
                    Forms\Components\TextInput::make('video_url')
                        ->url()
                        ->label('Link Video')
                        ->nullable(),
                    Forms\Components\TextInput::make('description')->label("Judul Video")
                    ->required()  
                ])
                ->columns(1)
                ->label('Video (opsional)'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')
                ->searchable(),
                Tables\Columns\TextColumn::make('title')->label('Judul Materi')
                ->searchable(),
                Tables\Columns\TextColumn::make('content')->limit(50)->label('Konten'),
                Tables\Columns\TextColumn::make('images_count')->counts('images')->label('Jumlah Gambar'),
                Tables\Columns\TextColumn::make('videos_count')->counts('videos')->label('Jumlah Video'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        if ($record->tests()->exists()) {
                        \Filament\Notifications\Notification::make()
                            ->title('Gagal Menghapus')
                            ->body('Materi ini sedang digunakan dan tidak bisa dihapus.')
                            ->danger()
                            ->send();
                        // return false; 
                        abort(403, 'Materi ini sedang digunakan didalam test');
                    }
                }),
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
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
