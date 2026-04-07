<?php require_once '../config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 'sans': ['Inter', 'sans-serif'] },
                    colors: { 'army': '#4B5320', 'army-light': '#6B7B3A', 'army-dark': '#2C331A' }
                }
            }
        }
    </script>
    <style>
        .bg-camouflage-login {
            background: linear-gradient(135deg, #eef2e6 0%, #d9e0cc 100%);
            background-image: radial-gradient(circle at 10% 20%, rgba(75, 83, 32, 0.1) 2%, transparent 2.5%),
                              radial-gradient(circle at 80% 70%, rgba(107, 123, 58, 0.1) 1.5%, transparent 2%);
            background-size: 50px 50px, 40px 40px;
        }
    </style>
    <title>Login Inventaris TNI</title>
</head>
<body class="bg-camouflage-login font-sans antialiased flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md px-4">
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl p-8 border border-white/20">
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-army rounded-2xl flex items-center justify-center shadow-lg mb-4">
                    <span class="text-white text-3xl font-bold">★</span>
                </div>
                <h2 class="text-3xl font-bold text-army-dark">Inventaris TNI</h2>
                <p class="text-gray-500 mt-1">Silakan login untuk melanjutkan</p>
            </div>
            <?php if(isset($_GET['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded-md mb-6 text-sm">❌ Username atau password salah!</div>
            <?php endif; ?>
            <form method="POST" action="../controllers/AuthController.php?action=login">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="username" required class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-army focus:border-transparent" placeholder="Masukkan username">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" required class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-army focus:border-transparent" placeholder="Masukkan password">
                    </div>
                </div>
                <button type="submit" class="w-full bg-army hover:bg-army-dark text-white font-semibold py-2.5 rounded-lg transition duration-200 transform hover:scale-[1.01] focus:outline-none focus:ring-2 focus:ring-army focus:ring-offset-2 shadow-md">
                    Login
                </button>
            </form>
            <div class="mt-6 text-center text-xs text-gray-400">
                Sistem Manajemen Logistik & Inventaris TNI
            </div>
        </div>
    </div>
</body>
</html>