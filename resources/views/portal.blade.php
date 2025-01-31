<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Siine MS') }} - Users Viewer</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <style type="text/tailwindcss">
            @theme {
              --color-clifford: #da373d;
            }
          </style>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class=" bg-gray-100">

            <!-- Page Content -->
            <main>

                <div style="height: 100vh;" class="relative bg-gradient-to-tr from-indigo-600 via-indigo-700 to-violet-800">
                    <div class="flex flex-col gap-4 justify-center items-center w-full h-full px-3 md:px-0">
                
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white">
                            Siine Micro-services
                        </h1>
                
                
                        <div class="shadow-lg rounded-lg overflow-hidden mx-3 md:mx-4">
                    <table class="w-full table-fixed">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Microservice</th>
                                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">URL</th>
                                <th class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr>
                                <td class="py-4 px-6 border-b border-gray-200">Users Viewer</td>
                                <td class="py-4 px-6 border-b border-gray-200">
                                    <a href="{{ route('users_viewer.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Access</a>
                                </td>
                                <td class="py-4 px-6 border-b border-gray-200">
                                    <span class="bg-green-500 text-white py-1 px-2 rounded-full text-xs">Active</span>
                                </td>
                            </tr>
                            <tr>

            </main>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    </body>
</html>
