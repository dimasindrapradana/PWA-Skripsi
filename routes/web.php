    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Auth\RegisterCustomController;
    use App\Http\Controllers\UserDashboardController;
    use App\Http\Controllers\Auth\UserLoginController;
    use App\Http\Controllers\Auth\UserRegisterController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\MaterialController;
    use App\Http\Controllers\SubmissionController;
    use App\Http\Controllers\TestController;
    use App\Http\Controllers\AdminLoginController;
    use App\Http\Controllers\Auth\ForgotPasswordController;
    use App\Http\Controllers\Auth\ResetPasswordController;



    // ======================
    // AUTH & USER ROUTES
    // ======================

    // Auth siswa
    Route::get('/login-siswa', [UserLoginController::class, 'showLoginForm'])->name('login.user');
    Route::post('/login-siswa', [UserLoginController::class, 'login'])->name('login.user.submit');

    Route::get('/register-siswa', [UserRegisterController::class, 'showRegisterForm'])->name('register.user');
    Route::post('/register-siswa', [UserRegisterController::class, 'register'])->name('register.user.submit');

    // Register custom untuk admin
    Route::get('/register-custom', [RegisterCustomController::class, 'show'])->name('register.custom.show');
    Route::post('/register-custom', [RegisterCustomController::class, 'register'])->name('register.custom');

    
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

    
    Route::get('/', fn () => view('layouts.landing'));
    Route::get('/categories', fn () => view('layouts.category'));
    Route::get('/materials', fn () => view('layouts.material'));

    Route::middleware('auth')->group(function () {

        // Dashboard pengguna
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

        // Materi & Detail Materi
        Route::get('/materi/{slug}', [MaterialController::class, 'show'])->name('materi.show');

        // Halaman daftar semua kuis
        Route::get('/kuis', [TestController::class, 'index'])->name('quiz.index');
      
        Route::get('/quiz/autocomplete', [TestController::class, 'autocomplete'])->name('quiz.autocomplete');

        //halaman materi
        Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/autocomplete', [MaterialController::class, 'autocomplete'])->name('materials.autocomplete');

        

        // Halaman mengerjakan kuis (per test/kuis)
        Route::get('/daftar-kuis', [TestController::class, 'index'])->name('quiz.list');

        Route::get('/kuis/{slug}', [TestController::class, 'show'])->name('quiz.show');
        Route::post('/kuis/{slug}', [TestController::class, 'submit'])->name('quiz.submit');

        // Hasil kuis
        Route::get('/kuis/hasil/{slug}', [TestController::class, 'result'])->name('quiz.result');


        // Submission tugas
        Route::post('/submission', [SubmissionController::class, 'store'])->name('submission.store');
    });
    // KATEGORI
        Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('kategori.show');

        use Illuminate\Support\Facades\Auth;
        Route::post('/logout', function () {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('login.user'); // redirect ke halaman login siswa
        })->name('logout');