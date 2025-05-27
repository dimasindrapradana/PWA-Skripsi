<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Material;
use App\Models\Test;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        
        $countUser = User::where('role', 'user')->count();
        $countAdmin = User::where('role', 'admin')->count();
        $countTest = Test::count();
        $countCategory = Category::count();
        $countMaterial = Material::count();
        
        return [
             Stat::make('Jumlah Siswa', $countUser)
                ->description('User dengan role siswa')
                ->color('success'),
             Stat::make('Jumlah Admin', $countAdmin)
                ->description('User dengan role admin')
                ->color('info'),
            Stat::make('Jumlah Quis', $countTest)
                ->description('Total kuis yang tersedia')
                ->color('success'),
            Stat::make('Jumlah Kategori', $countCategory)
                ->description('Total kategori yang tersedia')
                ->color('success'),
            Stat::make('Jumlah Materi', $countMaterial)
                ->description('Total materi yang tersedia')
                ->color('success'),
        ];
    }
}
