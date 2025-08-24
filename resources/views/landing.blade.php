<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Meta Description -->
        <meta
            name="description"
            content="Aplikasi motivasi penyejuk hati dari PT Anugerah Mandala Mulia Indonesia yang menghadirkan motivasi inspiratif dari Al-Qur'an semangat hidup setiap hari."
        />

        <!-- Meta Author -->
        <meta name="author" content="PT Anugerah Mandala Mulia Indonesia" />

        <!-- Meta Keywords -->
        <meta
            name="keywords"
            content="motivasi, inspirasi, aplikasi motivasi, penyejuk hati, semangat hidup, PT Anugerah Mandala Mulia Indonesia"
        />

        <!-- Open Graph Meta (untuk tampilan di media sosial) -->
        <meta property="og:title" content="Motivasi Penyejuk Hati" />
        <meta
            property="og:description"
            content="Aplikasi motivasi penyejuk hati dari PT Anugerah Mandala Mulia Indonesia yang menghadirkan motivasi inspiratif dari Al-Qur'an semangat hidup setiap hari."
        />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://motivasiislami.com" />
        <meta
            property="og:image"
            content="hhttps://motivasiislami.com/assets/img/small-logos/app-logo.webp"
        />

        <!-- Twitter Card Meta -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Motivasi Penyejuk Hati" />
        <meta
            name="twitter:description"
            content="Aplikasi motivasi penyejuk hati dari PT Anugerah Mandala Mulia Indonesia yang menghadirkan motivasi inspiratif dari Al-Qur'an semangat hidup setiap hari."
        />
        <meta
            name="twitter:image"
            content="https://motivasiislami.com/assets/img/small-logos/app-logo.webp"
        />

        <title>
            {{ config('app.name', 'E-Book Motivasi Al-Qur\'an') }} - PT
            Anugerah Mandala Mulia Indonesia
        </title>

        <link
            rel="icon"
            type="image/x-icon"
            href="/assets/img/small-logos/app-logo.webp"
        />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
            rel="stylesheet"
        />

        <link
            rel="stylesheet"
            type="text/css"
            href="/assets/css/landing.css?v=3"
        />

        @vite([])
    </head>

    <body>
        <section
            style="
                background-size: cover;
                background-position: bottom center;
                background-repeat: no-repeat;
                background-image: url('/assets/img/landing/hero-bg.svg');
            "
            class="relative min-h-svh flex"
        >
            <nav class="absolute top-0 left-0 right-0">
                <div class="px-4 container mx-auto flex gap-24 py-4">
                    <img
                        src="/assets/img/logo_clean.webp"
                        class="w-26 aspect-square object-cover my-auto"
                        alt=""
                    />

                    <div class="my-auto me-auto">
                        <ul class="hidden md:flex gap-8 font-semibold text-xl">
                            <li><a href="#">Home</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#testimoni">Testimoni</a></li>
                            <li><a href="#faq">FAQ</a></li>
                            <li><a href="#download">Download</a></li>
                        </ul>
                    </div>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-28"
                        viewBox="0 0 170 75"
                        fill="none"
                    >
                        <circle
                            opacity="0.24"
                            cx="37.5"
                            cy="37.5"
                            r="37.5"
                            fill="white"
                        />
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M41.3333 28.6667V23.7057C41.3333 21.4661 41.8479 20.3333 45.4635 20.3333H50V12H42.4302C33.1542 12 30.0938 16.0885 30.0938 23.1068V28.6667H24V37H30.0938V62H41.3333V37H48.9708L50 28.6667H41.3333Z"
                            fill="white"
                        />
                        <circle
                            opacity="0.235096"
                            cx="132.5"
                            cy="37.5"
                            r="37.5"
                            fill="#E1BEE7"
                        />
                        <ellipse
                            cx="132.457"
                            cy="37.5"
                            rx="8"
                            ry="8.5"
                            fill="#E1BEE7"
                        />
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M125.2 29.1091C127.291 27.0181 130.071 25.8542 133.028 25.8542C135.985 25.8542 138.765 27.0242 140.856 29.1152C142.183 30.442 143.131 32.0363 143.647 33.8155H151.957V22.6458C151.957 20.0254 149.932 18 147.311 18H118.844C116.223 18 114 20.0254 114 22.6458V33.8155H122.409C122.925 32.0363 123.873 30.4358 125.2 29.1091ZM148.794 26.2241C148.794 26.9229 148.228 27.4894 147.529 27.4894H143.733C143.034 27.4894 142.468 26.923 142.468 26.2241V22.4284C142.468 21.7297 143.034 21.1632 143.733 21.1632H147.529C148.228 21.1632 148.794 21.7296 148.794 22.4284V26.2241Z"
                            fill="white"
                        />
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M140.856 44.7656C138.765 46.8566 135.985 47.9958 133.028 47.9958C130.071 47.9958 127.291 46.8628 125.2 44.7718C123.113 42.6847 121.962 39.8451 121.957 36.9785H114V51.1136C114 53.7341 116.223 55.9571 118.844 55.9571H147.311C149.932 55.9571 151.957 53.7341 151.957 51.1136V36.9785H144.099C144.094 39.8451 142.943 42.6784 140.856 44.7656Z"
                            fill="white"
                        />
                    </svg>
                </div>
            </nav>

            <div class="container px-6 py-24 m-auto">
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="py-8">
                        <p
                            class="mt-8 mb-4 text-lg md:text-xl opacity-80 font-bold"
                        >
                            Kamu bisa mendapatkan motivasi yang bersumber dari
                            ayat-ayat Al-Qur'an
                        </p>

                        <div>
                            <ul class="list-disc px-5 font-semibold opacity-80">
                                <li class="mb-2">
                                    Lebih dari 200 ayat motivasi yang bisa kamu
                                    pilih sesuai mood yang kamu rasakan
                                </li>
                                <li class="mb-2">
                                    Bisa mengaktifkan reminder sesuai dengan
                                    mood yang kamu rasakan
                                </li>
                            </ul>
                        </div>

                        <p class="my-8 text-lg md:text-xl opacity-80 font-bold">
                            Selain mendapatkan motivasi, kamu sekaligus berbagi
                            kebaikan berkontribusi dalam kegiatan wakaf sumur
                            tanpa berdonasi
                        </p>

                        <div>
                            <ul class="list-disc px-5 font-semibold opacity-80">
                                <li class="mb-2">
                                    Wakaf sumur ini untuk memenuhi kebutuhan air
                                    bersih di masjid dan mushola
                                </li>
                                <li class="mb-2">
                                    Wakaf sumur ini juga untuk memenuhi
                                    kebutuhan air bersih bagi 200 KK
                                </li>
                                <li class="mb-2">
                                    InsyaAllah semoga bisa menjadi amal jariyah
                                    kamu
                                </li>
                            </ul>
                        </div>

                        <p class="my-8 text-lg md:text-xl opacity-80 font-bold">
                            Selain itu, kamu juga bisa berpeluang untuk bisa
                            berangkat umrah gratis
                        </p>

                        <div>
                            <ul class="list-disc px-5 font-semibold opacity-80">
                                <li class="mb-2">
                                    Motivasi Penyejuk Hati menyediakan
                                    tiket umrah gratis bagi yang beruntung
                                </li>
                                <li class="mb-2">
                                    Pengumuman akan dilakukan pada tanggal 31
                                    Desember 2025
                                </li>
                            </ul>
                        </div>

                        <p class="mt-8 mb-4 text-lg">
                            Jika kamu tertarik, caranya sangat mudah:
                        </p>
                        <p class="mb-4 text-lg">
                            <strong>Hanya dengan menjadi 'Sahabat MPH'</strong>
                        </p>
                        <p class="mb-10 text-lg">
                            Tinggal download aplikasi Motivasi Penyejuk Hati di Google Play Store
                        </p>

                        <div class="mt-4 flex">
                            <a
                                href="https://play.google.com/store/apps/details?id=com.motivasiislami.id&hl=id"
                                target="_blank"
                            >
                                <img
                                    src="/assets/img/landing/google-play.webp"
                                    class="w-48"
                                    alt=""
                                />
                            </a>
                        </div>
                    </div>
                    <div class="flex p-8">
                        <img
                            src="/assets/img/landing/hero.webp"
                            style="transform: rotate(-29.783deg)"
                            class="w-full m-auto drop-shadow-xl"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
