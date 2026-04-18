<?php

// Script untuk membuat struktur role system

$basePath = 'D:\\deenina';

// Buat directories
$directories = [
    $basePath . '\\app\\Http\\Middleware',
    $basePath . '\\resources\\views\\admin',
    $basePath . '\\resources\\views\\admin\\users',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created: $dir\n";
    }
}

// File Middleware CheckRole.php
$middlewareContent = '<?php

namespace App\\Http\\Middleware;

use Closure;
use Illuminate\\Http\\Request;
use Symfony\\Component\\HttpFoundation\\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, \'Unauthorized access\');
        }

        return $next($request);
    }
}
';

file_put_contents($basePath . '\\app\\Http\\Middleware\\CheckRole.php', $middlewareContent);
echo "Created: Middleware CheckRole.php\n";

// File View Dashboard
$dashboardContent = '@extends(\'layouts.app\')

@section(\'content\')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Admin Dashboard</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-4">{{ $usersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Admins</h5>
                    <p class="card-text display-4">{{ $adminsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Regular Users</h5>
                    <p class="card-text display-4">{{ $regularUsersCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <a href="{{ route(\'admin.users\') }}" class="btn btn-primary">Manage Users</a>
        </div>
    </div>
</div>
@endsection
';

file_put_contents($basePath . '\\resources\\views\\admin\\dashboard.blade.php', $dashboardContent);
echo "Created: Admin Dashboard View\n";

// File View Users Index
$usersContent = '@extends(\'layouts.app\')

@section(\'content\')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Manage Users</h1>
        </div>
    </div>

    @if ($message = Session::get(\'success\'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->isAdmin() ? \'bg-danger\' : \'bg-secondary\' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format(\'d M Y\') }}</td>
                        <td>
                            @if ($user->isAdmin())
                                <form action="{{ route(\'admin.users.demote\', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm(\'Demote this admin?\')">
                                        Demote to User
                                    </button>
                                </form>
                            @else
                                <form action="{{ route(\'admin.users.promote\', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm(\'Promote this user to admin?\')">
                                        Make Admin
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
';

file_put_contents($basePath . '\\resources\\views\\admin\\users\\index.blade.php', $usersContent);
echo "Created: Admin Users View\n";

echo "\n✅ Semua file berhasil dibuat!\n";
echo "Silakan jalankan: php artisan migrate\n";
?>
