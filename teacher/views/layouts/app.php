<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$config = json_decode(file_get_contents(__DIR__ . '/../../config.json'), true);
$global = $config['global'];

// Get user info - use passed variables first, then session, then defaults
$username = $username ?? $_SESSION['username'] ?? 'ผู้ใช้';
$fullname = $fullname ?? $_SESSION['fullname'] ?? $username;
$role = $role ?? $_SESSION['role'] ?? 'ครู';
?>
<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle ?? $global['pageTitle']; ?> | <?php echo $global['nameschool']; ?></title>
    
    <!-- Google Font: Mali -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mali:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS v3 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'mali': ['Mali', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        accent: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'slide-in-left': 'slideInLeft 0.3s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 2s infinite',
                        'spin-slow': 'spin 3s linear infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideInLeft: {
                            '0%': { opacity: '0', transform: 'translateX(-20px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        }
                    },
                    backdropBlur: {
                        xs: '2px',
                    }
                }
            }
        }
    </script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <style>
        * {
            font-family: 'Mali', sans-serif;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        }
        
        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .dark .glass {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Sidebar animation */
        .sidebar-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-item:hover {
            transform: translateX(8px);
        }
        
        /* Button animations */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(59, 130, 246, 0.5);
        }
        
        /* Card hover effects */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Loading spinner */
        .loader {
            border: 3px solid rgba(59, 130, 246, 0.2);
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* DataTables Custom Style */
        .dataTables_wrapper {
            padding: 1rem 0;
        }
        
        table.dataTable {
            border-collapse: collapse !important;
        }
        
        .dark table.dataTable tbody tr {
            background-color: #1e293b;
            color: #e2e8f0;
        }
        
        .dark table.dataTable tbody tr:hover {
            background-color: #334155 !important;
        }
    </style>
    
    <link rel="icon" type="image/png" href="../dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>">
</head>

<body class="font-mali bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 min-h-screen transition-colors duration-500">
    
    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-slate-900 transition-opacity duration-500">
        <div class="text-center">
            <img src="../dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>" alt="Logo" class="w-24 h-24 mx-auto animate-bounce-slow">
            <div class="loader mx-auto mt-6"></div>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300 animate-pulse"><?php echo $global['nameschool'] ?? 'ระบบบริหารงานทั่วไป'; ?></p>
        </div>
    </div>
    
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../components/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <!-- Navbar -->
            <?php include __DIR__ . '/../components/navbar.php'; ?>
            
            <!-- Page Content -->
            <main class="flex-1 p-4 md:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto animate-fade-in">
                    <?php echo $content ?? ''; ?>
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="py-4 px-6 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700">
                <p>&copy; <?php echo date('Y') + 543; ?> <?php echo $global['nameschool']; ?> - All rights reserved.</p>
                <p class="mt-1"><?php echo $global['footerCredit'] ?? ''; ?></p>
            </footer>
        </div>
    </div>
    
    <script>
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            setTimeout(() => {
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }, 800);
        });
        
        // Dark mode toggle
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }
        
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
        
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>
