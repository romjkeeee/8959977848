<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Answer;
use App\Policies\AnswerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Answer::class => AnswerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-question', function ($user, $question){
            return $user->id === $question->user_id;
        });

        Gate::define('delete-question', function($user, $question){
            return $user->id === $question->user_id;
        });

    }
}
