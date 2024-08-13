<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            flex-shrink: 0;
        }
        .sidebar a {
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <!-- Main Content -->
    <div class="content">
        @include('layouts.partials.navbar')

        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
