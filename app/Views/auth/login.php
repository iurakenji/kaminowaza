<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="<?=$theme['icon']?>" type="image/x-icon">
    <link href="<?=base_url()?>css/output.css?v=1.0" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-r <?= $theme['backg-color'] ?> flex items-center justify-center p-6">
    <div class="w-full max-w-md rounded-lg overflow-hidden">
        <div class="flex justify-center mt-4 bg-black">
                <img loading="lazy" decoding="async" src="<?= $theme['logo'] ?>" 
                    class="h-16" alt="Logo">
        </div>
        <div class="p-6">
            <h2 class="text-2xl font-semibold text-center text-gray-300">Autenticação</h2>
                <?= view_cell('ErrorMessageCell', 'type=error, message=Senha Incorreta.') ?>
            <form action="/login" method="post" class="mt-4">
                <div class="mt-4">
                    <label class="block text-gray-200">Usuário</label>
                    <input type="text" name="username" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-teal-400" required>
                </div>
                <div class="mt-4">
                    <label class="block text-gray-200">Senha</label>
                    <input type="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-teal-400" required>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <button type="submit" class="px-4 py-2 <?= $theme['buttonColor'] ?> text-white rounded-md focus:outline-none">Log In</button>
                    <button class="px-4 py-2 <?= $theme['buttonColor'] ?> text-white rounded-md focus:outline-none">Testar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="\public\js\modal-scripts.js"></script>
    <script src="https://unpkg.com/flowbite@1.6.4/dist/flowbite.js"></script>
</body>
</html>

