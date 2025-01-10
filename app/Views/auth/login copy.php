<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="<?=base_url()?>css/output.css?v=1.0" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 p-6">
    <div class="w-full max-w-md bg-gradient-to-r to-orange-300 via-orange-200 from-orange-300 shadow-lg shadow-orange-600/20 dark:shadow-lg rounded-lg overflow-hidden">
        <div class="flex justify-center mt-4">
            <img loading="lazy" decoding="async" src="https://institutosergiomurilo.com.br/wp-content/uploads/2020/08/dojo-min.png" 
                 class="h-16" alt="Logo">
        </div>
        <div class="p-6">
            <h2 class="text-2xl font-semibold text-center text-gray-300">Autenticação</h2>
                <div id="errorModal" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ms-3 text-sm font-medium">
                        Senha incorreta
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-2" aria-label="Close">
                        <span class="sr-only">Fechar</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            <form action="/login" method="post" class="mt-4">
                <div class="mt-4">
                    <label class="block text-gray-200">Username</label>
                    <input type="text" name="username" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-teal-400">
                </div>
                <div class="mt-4">
                    <label class="block text-gray-200">Senha</label>
                    <input type="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-teal-400">
                </div>
                <div class="flex items-center justify-between mt-4">
                    <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 focus:outline-none focus:bg-teal-600">Log In</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://unpkg.com/flowbite@1.6.4/dist/flowbite.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            
            
        });

        function showErrorModal() {
            document.getElementById('errorModal').classList.remove('hidden');
        }
    </script>
</body>
</html>

