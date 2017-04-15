<?php

namespace Laralum\Tickets;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laralum\Permissions\PermissionsChecker;
use Laralum\Tickets\Models\Message;
use Laralum\Tickets\Models\Settings;
use Laralum\Tickets\Models\Ticket;
use Laralum\Tickets\Policies\MessagePolicy;
use Laralum\Tickets\Policies\SettingsPolicy;
use Laralum\Tickets\Policies\TicketPolicy;

class TicketsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Message::class  => MessagePolicy::class,
        Ticket::class   => TicketPolicy::class,
        Settings::class => SettingsPolicy::class,
    ];

    /**
     * The mandatory permissions for the module.
     *
     * @var array
     */
    protected $permissions = [
        [
            'name' => 'Tickets Access',
            'slug' => 'laralum::tickets.access',
            'desc' => 'Grants access to tickets module',
        ],
        [
            'name' => 'Tickets Access (public)',
            'slug' => 'laralum::tickets.access-public',
            'desc' => 'Grants access to tickets module (public)',
        ],
        [
            'name' => 'Create Tickets',
            'slug' => 'laralum::tickets.create',
            'desc' => 'Allows creating tickets',
        ],
        [
            'name' => 'Create Tickets (public)',
            'slug' => 'laralum::tickets.create-public',
            'desc' => 'Allows creating tickets (public)',
        ],
        [
            'name' => 'Update Tickets',
            'slug' => 'laralum::tickets.update',
            'desc' => 'Allows updating tickets',
        ],
        [
            'name' => 'Update Tickets (public)',
            'slug' => 'laralum::tickets.update-public',
            'desc' => 'Allows updating tickets (public)',
        ],
        [
            'name' => 'View Tickets',
            'slug' => 'laralum::tickets.view',
            'desc' => 'Allows view tickets',
        ],
        [
            'name' => 'View Tickets (public)',
            'slug' => 'laralum::tickets.view-public',
            'desc' => 'Allows view tickets (public)',
        ],
        [
            'name' => 'Delete Tickets',
            'slug' => 'laralum::tickets.delete',
            'desc' => 'Allows delete tickets',
        ],
        [
            'name' => 'Delete Tickets (public)',
            'slug' => 'laralum::tickets.delete-public',
            'desc' => 'Allows delete tickets (public)',
        ],
        [
            'name' => 'Manage Tickets Status',
            'slug' => 'laralum::tickets.status',
            'desc' => 'Allows close and open tickets',
        ],
        [
            'name' => 'Manage Tickets Status (public)',
            'slug' => 'laralum::tickets.status-public',
            'desc' => 'Allows close and open tickets (public)',
        ],
        [
            'name' => 'Reply Tickets Messages',
            'slug' => 'laralum::tickets.reply',
            'desc' => 'Allows Reply tickets messages',
        ],
        [
            'name' => 'Reply Tickets Messages (public)',
            'slug' => 'laralum::tickets.reply-public',
            'desc' => 'Allows reply tickets messages (public)',
        ],
        [
            'name' => 'Update Tickets Messages',
            'slug' => 'laralum::tickets.messages.update',
            'desc' => 'Allows updating tickets messages',
        ],
        [
            'name' => 'Update Tickets Messages (public)',
            'slug' => 'laralum::tickets.messages.update-public',
            'desc' => 'Allows updating tickets messages (public)',
        ],
        [
            'name' => 'Delete Tickets Messages',
            'slug' => 'laralum::tickets.messages.delete',
            'desc' => 'Allows deleting tickets messages',
        ],
        [
            'name' => 'Delete Tickets Messages (public)',
            'slug' => 'laralum::tickets.messages.delete-public',
            'desc' => 'Allows delete tickets messages (public)',
        ],
        [
            'name' => 'Update Tickets Settings',
            'slug' => 'laralum::tickets.settings',
            'desc' => 'Allows update tickets settings',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->loadTranslationsFrom(__DIR__.'/Translations', 'laralum_tickets');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->publishes([
            __DIR__.'/Views/public' => resource_path('views/vendor/laralum/tickets'),
        ], 'laralum_tickets');

        $this->app->register('GrahamCampbell\\Markdown\\MarkdownServiceProvider');

        $this->loadViewsFrom(__DIR__.'/Views', 'laralum_tickets'); //Loading private views
        //$this->loadViewsFrom(resource_path('views/vendor/Laralum/Tickets'), 'laralum_tickets_public'); //Loading public views
        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Make sure the permissions are OK
        PermissionsChecker::check($this->permissions);
    }

    /**
     * I cheated this comes from the AuthServiceProvider extended by the App\Providers\AuthServiceProvider.
     *
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
