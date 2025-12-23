<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Terkini</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-[#f8fafc] font-habanera">
    @extends('layout.admin')

        @section('content')
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <h2 class="text-lg font-semibold mb-3">Welcome!</h2>
                <p class="text-gray-600">Konten utama Pengguna berada di sini.</p>
            </div>
        @endsection
</body>
</html>
