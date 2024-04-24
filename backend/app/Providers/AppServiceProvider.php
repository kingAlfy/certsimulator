<?php

namespace App\Providers;

use App\Repository\CommentRepositoryImpl;
use App\Repository\ExamRepositoryImpl;
use App\Repository\ICommentRepository;
use App\Repository\IExamRepository;
use App\Repository\IQuestionRepository;
use App\Repository\QuestionRepositoryImpl;
use App\Services\ExamProcessorImpl;
use App\Services\ExamServiceImpl;
use App\Services\ExamUnzipperImpl;
use App\Services\IExamProcessor;
use App\Services\IExamService;
use App\Services\IExamUnzipper;
use App\Services\IQuestionService;
use App\Services\QuestionServiceImpl;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ICommentRepository::class, CommentRepositoryImpl::class);
        $this->app->bind(IQuestionService::class, QuestionServiceImpl::class);
        $this->app->bind(IQuestionRepository::class, QuestionRepositoryImpl::class);
        $this->app->bind(IExamProcessor::class, ExamProcessorImpl::class);
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
