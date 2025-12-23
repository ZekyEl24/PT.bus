<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Masuk - PT.Berkat Untuk Sesama</title>
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>

<body class="antialiased bg-gray-50 relative overflow-hidden">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-55 right-[70px] w-[376px] h-[466px] bg-birua -rotate-46 origin-top-right"></div>
        <div
            class="absolute -bottom-20 -left-20 w-[300px] h-[300px] bg-linear-to-tr from-kuning to-kuningterang rounded-full">
        </div>
    </div>

    <div class="flex items-center justify-center min-h-screen relative p-4">
        <div class="bg-white rounded-[10px] shadow-xl max-w-[1300px] w-[95%] relative flex min-h-[490px] -translate-y-2">
            <div class="w-1/2 rounded-s-[10px] flex flex-col justify-center items-center p-8 border-r border-gray-300 relative overflow-hidden"
                style="background-color:#fafafa;">
                <div class="absolute -bottom-[135px] -left-32 w-[300px] h-[300px] bg-kuningterang rounded-full"></div>
                <div class="mb-4">
                    <div class="w-25 h-25 flex items-center justify-center rounded-sm">
                        <img src="{{ $profilPerusahaan && $profilPerusahaan->logo
                            ? asset($profilPerusahaan->logo)
                            : asset('assets/default-logo.png') }}"
                            class="logo-img w-25 h-25 object-contain" alt="Logo">
                    </div>
                </div>
                <h1 class="text-xl text-birugelapxl font-habanera font-bold mt-4">
                    {{ $profilPerusahaan->nama_profil ?? 'Nama Perusahaan' }}
                </h1>
                <img src="/assets/foto/aksesoris1.png"
                    class="absolute opacity-80 w-[230px] right-2 -top-12 pointer-events-none select-none" />
            </div>

            <div class="w-1/2 rounded-[10px] p-8 flex flex-col justify-center bg-white">
                <h2 class="text-[40px] font-montserrat font-bold text-birua mb-2">Masuk</h2>
                <p class="text-abutext mb-4 text-sm font-montserrat font-regular">Masuk dengan email dan kata sandi yang
                    telah terdaftar</p>

                <br>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="email" class="sr-only">Email</label>
                        <div class="relative">
                            <input type="text" id="email" name="email" value="{{ old('email') }}" required
                                autofocus placeholder="Email"
                                class="w-full py-3 pl-12 pr-4 rounded-lg border-gray-300 border-dashed border @error('email') border-error focus:border-error focus:ring-error border-solid @enderror">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 20 20">
                                    <path fill="currentColor"
                                        d="M15.5 4A2.5 2.5 0 0 1 18 6.5v8a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 2 14.5v-8A2.5 2.5 0 0 1 4.5 4zM17 7.961l-6.746 3.97a.5.5 0 0 1-.426.038l-.082-.038L3 7.963V14.5A1.5 1.5 0 0 0 4.5 16h11a1.5 1.5 0 0 0 1.5-1.5zM15.5 5h-11A1.5 1.5 0 0 0 3 6.5v.302l7 4.118l7-4.12v-.3A1.5 1.5 0 0 0 15.5 5" />
                                </svg></span>
                        </div>

                        @error('email')
                            <p class="text-error text-xs font-montserrat mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="sr-only">Kata sandi</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required placeholder="Kata sandi"
                                class="w-full py-3 pl-12 pr-4 rounded-lg border-gray-300 border-dashed border @error('password') border-error focus:border-error focus:ring-error border-solid @enderror">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 22 22">
                                    <path fill="currentColor"
                                        d="M6.616 21q-.672 0-1.144-.472T5 19.385v-8.77q0-.67.472-1.143Q5.944 9 6.616 9H8V7q0-1.671 1.165-2.835Q10.329 3 12 3t2.836 1.165T16 7v2h1.385q.67 0 1.143.472q.472.472.472 1.144v8.769q0 .67-.472 1.143q-.472.472-1.143.472zm0-1h10.769q.269 0 .442-.173t.173-.442v-8.77q0-.269-.173-.442T17.385 10H6.615q-.269 0-.442.173T6 10.616v8.769q0 .269.173.442t.443.173M12 16.5q.633 0 1.066-.434q.434-.433.434-1.066t-.434-1.066T12 13.5t-1.066.434Q10.5 14.367 10.5 15t.434 1.066q.433.434 1.066.434M9 9h6V7q0-1.25-.875-2.125T12 4t-2.125.875T9 7zM6 20V10z" />
                                </svg></span>
                            <span
                                class="absolute inset-y-0 right-4 flex items-center justify-center text-gray-400 cursor-pointer"
                                id="togglePassword">
                                <svg id="eyeOpen" class="w-7 h-7 block" viewBox="-1 0 22 22">
                                    <path fill="currentColor"
                                        d="M3.26 11.602C3.942 8.327 6.793 6 10 6s6.057 2.327 6.74 5.602a.5.5 0 0 0 .98-.204C16.943 7.673 13.693 5 10 5s-6.943 2.673-7.72 6.398a.5.5 0 0 0 .98.204M10 8a3.5 3.5 0 1 0 0 7a3.5 3.5 0 0 0 0-7m-2.5 3.5a2.5 2.5 0 1 1 5 0a2.5 2.5 0 0 1-5 0" />
                                </svg>

                                <!-- ikon mata tertutup -->
                                <svg id="eyeClose" class="w-7 h-7 hidden" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="-1 0 22 22">
                                    <path fill="currentColor"
                                        d="M2.854 2.146a.5.5 0 1 0-.708.708l3.5 3.498a8.1 8.1 0 0 0-3.366 5.046a.5.5 0 1 0 .98.204a7.1 7.1 0 0 1 3.107-4.528L7.953 8.66a3.5 3.5 0 1 0 4.886 4.886l4.307 4.308a.5.5 0 0 0 .708-.708zm9.265 10.68A2.5 2.5 0 1 1 8.673 9.38zm-1.995-4.824l3.374 3.374a3.5 3.5 0 0 0-3.374-3.374M10 6c-.57 0-1.129.074-1.666.213l-.803-.803A7.7 7.7 0 0 1 10 5c3.693 0 6.942 2.673 7.72 6.398a.5.5 0 0 1-.98.204C16.058 8.327 13.207 6 10 6" />
                                </svg>
                            </span>
                        </div>

                        @error('password')
                            <p class="text-error text-xs font-montserrat mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center mb-6 mt-6 text-sm">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember"
                                class="h-4 w-4 accent-birub border-gray-300 rounded focus:ring-birugelapxl">
                            <label for="remember" class="ml-2 text-birugelapxl font-inter font-regular text-sm">Ingat
                                saya</label>
                        </div>
                        <a href="#" class="text-birugelapxl font-inter font-regular hover:underline text-sm">Lupa
                            sandi?</a>
                    </div>

                    <br>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="w-[214px] h-12 bg-birua hover:bg-biruc text-white font-habanera font-semibold py-3 rounded-xl shadow-md transition duration-150">
                            Masuk
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>

    <footer class="absolute bottom-4 w-full text-center text-xs text-birugelapxl font-poppins translate-y-1">
        © 2025 <span class="font-bold text-[#38a1e2]">coding</span><span class="font-bold text-[#3b3b3b]">.site</span> -
        Created for PT.Berkat Untuk Sesama. All rights reserved.
    </footer>

    <script>
        const pw = document.getElementById("password");
        const toggle = document.getElementById("togglePassword");
        const eye = document.getElementById("eyeOpen");
        const eyeClose = document.getElementById("eyeClose");

        toggle.addEventListener("click", () => {
            const type = pw.type === "password" ? "text" : "password";
            pw.type = type;
            eye.classList.toggle("hidden");
            eyeClose.classList.toggle("hidden");
        });
    </script>


</body>

</html>
