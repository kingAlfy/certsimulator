<?php

namespace App\Providers;

use App\Repository\ExamRepositoryImpl;
use App\Repository\IExamRepository;
use App\Services\ExamServiceImpl;
use App\Services\ExamUnzipperImpl;
use App\Services\IExamService;
use App\Services\IExamUnzipper;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IExamUnzipper::class, ExamUnzipperImpl::class);
        $this->app->bind(IExamService::class, ExamServiceImpl::class);
        $this->app->bind(IExamRepository::class, ExamRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
