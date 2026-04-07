<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Inventaris TNI - Sistem Manajemen Logistik</title>
    <!-- Tailwind CSS + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <!-- Custom config Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'army': '#4B5320',
                        'army-light': '#6B7B3A',
                        'army-dark': '#2C331A',
                    }
                }
            }
        }
    </script>
    <style>
        /* Background pattern loreng (camouflage) subtle */
        .bg-camouflage {
            background-color: #eef2e6;
            background-image: radial-gradient(circle at 10% 20%, rgba(75, 83, 32, 0.08) 2%, transparent 2.5%),
                              radial-gradient(circle at 80% 70%, rgba(107, 123, 58, 0.08) 1.5%, transparent 2%);
            background-size: 40px 40px, 35px 35px;
        }
        /* Card hover effect */
        .card-hover {
            transition: all 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }
        /* Tabel responsive overflow */
        .table-responsive {
            overflow-x: auto;
            border-radius: 0.75rem;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #4B5320;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-camouflage font-sans antialiased">
    <!-- Navbar dengan efek blur dan warna solid -->
    <nav class="bg-white/95 backdrop-blur-sm border-b border-army-light/30 shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-army rounded-lg flex items-center justify-center">
                        <span class="text-white text-sm font-bold">★</span>
                    </div>
                    <span class="font-bold text-xl text-army-dark tracking-tight">Sistem Inventaris TNI</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center space-x-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span><?= htmlspecialchars($_SESSION['nama'] ?? 'Guest') ?></span>
                        <span class="px-2 py-0.5 bg-army-light/20 text-army-dark rounded-full text-xs font-medium"><?= $_SESSION['role'] ?? '' ?></span>
                    </div>
                    <a href="/inventaris/logout.php" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-army hover:bg-army-dark focus:outline-none transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">