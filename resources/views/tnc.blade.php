<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>Kebijakan Privasi - {{ config('app.name', 'E-Book Motivasi Al-Qur\'an') }}</title>

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

        <link rel="stylesheet" type="text/css" href="/assets/css/landing.css" />

        @vite([])
    </head>

    <body
        style="
            background-position: top center;
            background-repeat: no-repeat;
            background-image: url('/assets/img/landing/hero-bg.svg');
        "
    >
        <nav>
            <div class="px-4 container mx-auto flex gap-24 py-4">
                <img
                    src="/assets/img/logo_clean.webp"
                    class="w-26 aspect-square object-cover my-auto"
                    alt=""
                />

                <div class="my-auto me-auto">
                    <ul class="hidden md:flex gap-8 font-semibold text-xl">
                        <li><a href="/#">Home</a></li>
                        <li><a href="/#about">About</a></li>
                        <li><a href="/#testimoni">Testimoni</a></li>
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

        <section class="leading-relaxed">
            <div class="max-w-4xl mx-auto px-6 py-10">
                <h1 class="text-3xl font-bold text-center mb-4">
                    KEBIJAKAN PRIVASI
                </h1>
                <h2 class="text-center text-lg font-medium mb-10">
                    Aplikasi Mobile Motivasi Penyejuk Hati
                </h2>
                <p class="text-sm text-center text-gray-600 mb-10">
                    Versi Terakhir: 6 Desember 2024
                </p>

                <p class="mb-4">
                    Kami, [motivasiislami.com] ("Kami"), menghargai privasi Anda
                    dan berkomitmen untuk melindungi data pribadi yang Anda
                    berikan saat menggunakan aplikasi mobile Motivasi Penyejuk
                    Hati ("Aplikasi"). Kebijakan Privasi ini menjelaskan
                    bagaimana Kami mengumpulkan, menggunakan, menyimpan, dan
                    melindungi informasi pribadi Anda.
                </p>
                <p class="mb-4">
                    Dengan menggunakan Aplikasi, Anda menyetujui pengumpulan dan
                    penggunaan informasi sebagaimana diatur dalam Kebijakan
                    Privasi ini. Jika Anda tidak setuju, mohon untuk tidak
                    menggunakan Aplikasi ini.
                </p>

                <h2 class="text-xl font-semibold mt-8 mb-2">
                    1. Informasi yang Kami Kumpulkan
                </h2>
                <p class="mb-2 font-medium">1.1 Informasi Pribadi</p>
                <ul class="list-disc list-inside mb-4">
                    <li>Nama lengkap.</li>
                    <li>Alamat email.</li>
                    <li>Nomor telepon</li>
                    <li>Domisili</li>
                    <li>Usia.</li>
                    <li>
                        Informasi pembayaran (hanya digunakan saat Anda
                        melakukan pembelian).
                    </li>
                </ul>

                <p class="mb-2 font-medium">1.2 Informasi Teknis</p>
                <ul class="list-disc list-inside mb-4">
                    <li>Alamat IP.</li>
                    <li>Jenis perangkat dan sistem operasi.</li>
                    <li>
                        Log aktivitas di Aplikasi (misalnya, halaman yang
                        diakses, waktu penggunaan).
                    </li>
                </ul>

                <p class="mb-2 font-medium">1.3 Informasi Pihak Ketiga</p>
                <p class="mb-4">
                    Jika Anda mendaftar atau login menggunakan akun media sosial
                    (jika tersedia), Kami dapat mengakses informasi dasar dari
                    akun tersebut, seperti nama dan alamat email.
                </p>

                <h2 class="text-xl font-semibold mt-8 mb-2">
                    2. Cara Kami Menggunakan Informasi Anda
                </h2>
                <p class="mb-2 font-medium">2.1 Memberikan Layanan</p>
                <ul class="list-disc list-inside mb-4">
                    <li>Memproses registrasi akun dan login.</li>
                    <li>
                        Mengelola transaksi pembelian konten premium melalui
                        integrasi dengan API Xendit.
                    </li>
                    <li>
                        Menyediakan akses ke e-book Islami dan artikel yang
                        relevan.
                    </li>
                </ul>
                <p class="mb-2 font-medium">
                    2.2 Meningkatkan Pengalaman Pengguna
                </p>
                <ul class="list-disc list-inside mb-4">
                    <li>
                        Meningkatkan performa Aplikasi berdasarkan data teknis.
                    </li>
                    <li>
                        Menyediakan rekomendasi e-book yang sesuai dengan
                        preferensi Anda.
                    </li>
                </ul>
                <p class="mb-2 font-medium">2.3 Keamanan</p>
                <ul class="list-disc list-inside mb-4">
                    <li>
                        Mendeteksi dan mencegah aktivitas mencurigakan, seperti
                        akses tidak sah atau penyalahgunaan fitur.
                    </li>
                    <li>
                        Memastikan perlindungan konten dengan watermark
                        otomatis.
                    </li>
                </ul>
                <p class="mb-2 font-medium">2.4 Komunikasi</p>
                <ul class="list-disc list-inside mb-4">
                    <li>
                        Mengirimkan pemberitahuan terkait akun, pembaruan
                        Aplikasi, dan penawaran khusus melalui email atau push
                        notification (jika Anda mengizinkan).
                    </li>
                </ul>

                <h2 class="text-xl font-semibold mt-8 mb-2">
                    3. Bagaimana Kami Melindungi Data Anda
                </h2>
                <p class="mb-2 font-medium">3.1 Enkripsi</p>
                <p class="mb-2">
                    Semua data pribadi dan informasi pembayaran dienkripsi
                    menggunakan protokol keamanan (seperti HTTPS dan SSL) untuk
                    mencegah akses tidak sah selama transmisi.
                </p>
                <p class="mb-2 font-medium">3.2 Pembatasan Akses</p>
                <p class="mb-2">
                    Hanya karyawan yang berwenang yang dapat mengakses data
                    pribadi Anda.
                </p>
                <p class="mb-2 font-medium">3.3 Audit Keamanan</p>
                <p class="mb-4">
                    Kami secara rutin memeriksa sistem Kami untuk memastikan
                    tidak ada kerentanan atau ancaman keamanan.
                </p>

                <h2 class="text-xl font-semibold mt-8 mb-2">
                    4. Pembagian Informasi
                </h2>
                <p class="mb-2">
                    Kami tidak akan menjual, menyewakan, atau membagikan data
                    pribadi Anda kepada pihak ketiga, kecuali dalam situasi
                    berikut:
                </p>
                <p class="mb-2 font-medium">4.1 Layanan Pihak Ketiga</p>
                <ul class="list-disc list-inside mb-4">
                    <li>
                        Penyedia Layanan Pembayaran: Data terkait transaksi akan
                        dibagikan dengan Xendit untuk memproses pembayaran.
                    </li>
                    <li>
                        Penyedia Hosting: Data Anda disimpan di server yang
                        disediakan oleh penyedia hosting terpercaya.
                    </li>
                </ul>
                <p class="mb-2 font-medium">4.2 Persyaratan Hukum</p>
                <p class="mb-2">
                    Kami dapat membagikan data Anda jika diwajibkan oleh hukum
                    atau untuk memenuhi permintaan yang sah dari pihak berwenang
                    (misalnya, polisi atau pengadilan).
                </p>
                <p class="mb-2 font-medium">4.3 Perlindungan Hak</p>
                <p class="mb-4">
                    Jika diperlukan untuk melindungi hak, properti, atau
                    keselamatan Kami, pengguna lain, atau masyarakat umum.
                </p>

                <h2 class="text-xl font-semibold mt-8 mb-2">
                    5. Cookie dan Teknologi Serupa
                </h2>
                <p class="mb-4">
                    Kami menggunakan cookie dan teknologi serupa untuk
                    meningkatkan pengalaman Anda saat menggunakan Aplikasi.
                    Cookie digunakan untuk:
                </p>
                <ul class="list-disc list-inside mb-4">
                    <li>Menyimpan preferensi pengguna.</li>
                    <li>
                        Menganalisis penggunaan Aplikasi untuk meningkatkan
                        layanan.
                    </li>
                </ul>
                <p class="mb-4">
                    Anda dapat menonaktifkan cookie melalui pengaturan perangkat
                    Anda, tetapi ini mungkin memengaruhi fungsi tertentu dalam
                    Aplikasi.
                </p>

                <h2 class="text-xl font-semibold mt-8 mb-2">6. Hak Anda</h2>
                <p class="mb-2 font-medium">6.1 Akses Data</p>
                <p class="mb-2">
                    Anda dapat meminta salinan informasi pribadi yang telah Kami
                    kumpulkan.
                </p>
                <p class="mb-2 font-medium">6.2 Perbaikan Data</p>
                <p class="mb-2">
                    Anda dapat meminta Kami untuk memperbarui atau memperbaiki
                    informasi pribadi yang tidak akurat.
                </p>
                <p class="mb-2 font-medium">6.3 Penghapusan Data</p>
                <p class="mb-2">
                    Anda dapat meminta penghapusan akun dan data pribadi Anda,
                    kecuali jika data tersebut diperlukan untuk memenuhi
                    kewajiban hukum Kami.
                </p>
                <p class="mb-2 font-medium">6.4 Menolak Komunikasi</p>
                <p class="mb-2">
                    Anda dapat memilih untuk berhenti menerima email promosi
                    atau push notification kapan saja melalui pengaturan akun
                    Anda.
                </p>

                <h2 class="text-xl font-semibold mt-8 mb-2">
                    7. Penyimpanan Data
                </h2>
                <p class="mb-4">
                    Kami hanya menyimpan data pribadi Anda selama diperlukan
                    untuk tujuan yang telah dijelaskan dalam Kebijakan Privasi
                    ini, atau untuk memenuhi kewajiban hukum Kami. Jika Anda
                    menghapus akun, data Anda akan dihapus dari server Kami
                    dalam waktu 30 hari, kecuali data tertentu yang harus
                    disimpan untuk keperluan hukum atau akuntansi.
                </p>

                <h2 class="text-xl font-semibold mt-8 mb-2">
                    8. Perubahan Kebijakan Privasi
                </h2>
                <p class="mb-4">
                    Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke
                    waktu. Jika ada perubahan material, Kami akan memberi tahu
                    Anda melalui Aplikasi atau email terdaftar Anda sebelum
                    perubahan diberlakukan. Tanggal revisi terakhir akan
                    ditampilkan di bagian atas dokumen ini.
                </p>

                <h2 class="text-xl font-semibold mt-8 mb-2">9. Anak-Anak</h2>
                <p class="mb-4">
                    Aplikasi ini tidak ditujukan untuk anak-anak di bawah usia
                    13 tahun. Kami tidak secara sengaja mengumpulkan informasi
                    pribadi dari anak-anak tanpa persetujuan orang tua atau wali
                    mereka. Jika Anda mengetahui bahwa seorang anak telah
                    memberikan data pribadinya tanpa persetujuan, silakan
                    hubungi Kami untuk penghapusan.
                </p>

                <h2 class="text-xl font-semibold mt-8 mb-2">10. Kontak Kami</h2>
                <p class="mb-4">
                    Jika Anda memiliki pertanyaan, saran, atau keluhan terkait
                    Kebijakan Privasi ini, silakan hubungi Kami melalui:
                    <br />
                    <strong>Email:</strong>
                    <a
                        href="mailto:motivasi.ph@gmail.com"
                        class="text-blue-600 hover:underline"
                    >
                        motivasi.ph@gmail.com
                    </a>
                </p>
            </div>
        </section>

        <div
            style="
                background-position: bottom;
                background-repeat: no-repeat;
                background-image: url('/assets/img/landing/footer-bg.svg');
            "
            class="bg-cover lg:bg-contain"
            id="faq"
        >
            <section>
                <div class="px-4 container mx-auto">
                    <div class="py12 xl:py-24">
                        <h2
                            class="font-semibold text-3xl md:text-4xl xl:text-5xl mb-16"
                        >
                            FAQ
                        </h2>

                        <div
                            class="w-20 h-2 rounded-md"
                            style="
                                background: linear-gradient(
                                    169deg,
                                    #b2ebf2 -58.33%,
                                    #d1c4e9 60.57%
                                );
                            "
                        ></div>
                    </div>

                    <div class="grid lg:grid-cols-2 my-auto gap-8">
                        <div class="flex p-8">
                            <img
                                src="/assets/img/landing/faq.png"
                                class="w-[80%] mx-auto mb-auto"
                                alt=""
                            />
                        </div>
                        <div class="min-h-svh">
                            <!-- component -->
                            <div class="bg-white rounded-2xl shadow-2xl">
                                <div
                                    class="rounded-t-xl bg-primary group flex flex-col gap-2 px-8 py-8"
                                    tabindex="1"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span
                                            class="font-semibold text-lg sm:text-xl text-white"
                                        >
                                            FAQ
                                        </span>
                                        <img
                                            alt=""
                                            src="/assets/img/landing/arrow.svg"
                                            class="w-4 transition-all duration-500 group-focus:-rotate-180"
                                        />
                                    </div>
                                </div>

                                <div
                                    class="group flex flex-col gap-2 px-8 py-8"
                                    tabindex="1"
                                >
                                    <div
                                        class="flex cursor-pointer items-center justify-between"
                                    >
                                        <span
                                            class="font-semibold text-lg sm:text-xl"
                                        >
                                            Apa nama aplikasi ini?
                                        </span>
                                        <img
                                            alt=""
                                            src="/assets/img/landing/arrow.svg"
                                            class="w-4 transition-all duration-500 group-focus:-rotate-180"
                                        />
                                    </div>
                                    <div
                                        class="invisible h-auto max-h-0 items-center opacity-0 transition-all group-focus:visible group-focus:max-h-screen group-focus:opacity-100 group-focus:duration-1000"
                                    >
                                        Motivasi Penyejuk Hati.
                                    </div>
                                </div>

                                <div
                                    class="group flex flex-col gap-2 px-8 py-8"
                                    tabindex="2"
                                >
                                    <div
                                        class="flex cursor-pointer items-center justify-between"
                                    >
                                        <span
                                            class="font-semibold text-lg sm:text-xl"
                                        >
                                            Aplikasi ini isinya tentang apa?
                                        </span>
                                        <img
                                            alt=""
                                            src="/assets/img/landing/arrow.svg"
                                            class="w-4 transition-all duration-500 group-focus:-rotate-180"
                                        />
                                    </div>
                                    <div
                                        class="invisible h-auto max-h-0 items-center opacity-0 transition-all group-focus:visible group-focus:max-h-screen group-focus:opacity-100 group-focus:duration-1000"
                                    >
                                        Tentang motivasi dan pengingat agar
                                        lebih semangat menjalani kehidupan
                                        sehari-hari dengan berbagai permasalahan
                                        yang dihadapi.
                                    </div>
                                </div>

                                <div
                                    class="group flex flex-col gap-2 px-8 py-8"
                                    tabindex="3"
                                >
                                    <div
                                        class="flex cursor-pointer items-center justify-between"
                                    >
                                        <span
                                            class="font-semibold text-lg sm:text-xl"
                                        >
                                            Apa bedanya dengan aplikasi motivasi
                                            yang lain?
                                        </span>
                                        <img
                                            alt=""
                                            src="/assets/img/landing/arrow.svg"
                                            class="w-4 transition-all duration-500 group-focus:-rotate-180"
                                        />
                                    </div>
                                    <div
                                        class="invisible h-auto max-h-0 items-center opacity-0 transition-all group-focus:visible group-focus:max-h-screen group-focus:opacity-100 group-focus:duration-1000"
                                    >
                                        Isi aplikasi ini bersumber dari
                                        Al-Qur'an, yang tidak diragukan lagi
                                        kebenarannya.
                                    </div>
                                </div>

                                <div
                                    class="group flex flex-col gap-2 px-8 py-8"
                                    tabindex="4"
                                >
                                    <div
                                        class="flex cursor-pointer items-center justify-between"
                                    >
                                        <span
                                            class="font-semibold text-lg sm:text-xl"
                                        >
                                            Apa manfaatnya jika membaca isi
                                            aplikasi ini?
                                        </span>
                                        <img
                                            alt=""
                                            src="/assets/img/landing/arrow.svg"
                                            class="w-4 transition-all duration-500 group-focus:-rotate-180"
                                        />
                                    </div>
                                    <div
                                        class="invisible h-auto max-h-0 items-center opacity-0 transition-all group-focus:visible group-focus:max-h-screen group-focus:opacity-100 group-focus:duration-1000"
                                    >
                                        Manfaatnya InsyaAllah hati dan pikiran
                                        menjadi lebih tenang, lebih ikhlas dalam
                                        menjalani kehidupan, dan menjadikan diri
                                        semakin mendekat kepada ALLAH SWT.
                                    </div>
                                </div>

                                <div
                                    class="rounded-b-xl group flex flex-col gap-2 px-8 py-8"
                                    tabindex="5"
                                >
                                    <div
                                        class="flex cursor-pointer items-center justify-between"
                                    >
                                        <span
                                            class="font-semibold text-lg sm:text-xl"
                                        >
                                            Apakah aplikasi ini gratis?
                                        </span>
                                        <img
                                            alt=""
                                            src="/assets/img/landing/arrow.svg"
                                            class="w-4 transition-all duration-500 group-focus:-rotate-180"
                                        />
                                    </div>
                                    <div
                                        class="invisible h-auto max-h-0 items-center opacity-0 transition-all group-focus:visible group-focus:max-h-screen group-focus:opacity-100 group-focus:duration-1000"
                                    >
                                        Gratis dengan akses terbatas. Jika ingin
                                        mengakses semuanya, maka hanya perlu
                                        membayar sekali saja dengan harga yang
                                        sangat terjangkau. Setiap kali ada
                                        update, tidak perlu membayar lagi.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="relative pt-32 pb-8">
                <div class="px-4 container mx-auto py-8">
                    <div class="pb-12 xl:pb-32">
                        <h5
                            class="text-3xl md:text-4xl font-bold mb-6 text-white text-center"
                        >
                            Apalagi yang kamu tunggu?
                            <br />
                            Download sekarang yuk!
                        </h5>

                        <div class="my-24 flex justify-center" id="download">
                            <img
                                src="/assets/img/landing/google-play.webp"
                                class="w-48"
                                alt=""
                            />
                        </div>
                    </div>

                    <div class="max-w-[300px] text-white">
                        <h6 class="text-xl font-bold mb-6">
                            Motivasiislami.com
                        </h6>

                        <div>
                            <svg
                                class="w-30"
                                viewBox="0 0 174 75"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <ellipse
                                    cx="37.5"
                                    cy="37.6737"
                                    rx="37.5"
                                    ry="37.3172"
                                    fill="#00BCD4"
                                />
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M41.3333 28.8833V23.9465C41.3333 21.7179 41.8479 20.5906 45.4635 20.5906H50V12.2979H42.4302C33.1542 12.2979 30.0938 16.3665 30.0938 23.3505V28.8833H24V37.176H30.0938V62.0542H41.3333V37.176H48.9708L50 28.8833H41.3333Z"
                                    fill="white"
                                />
                                <ellipse
                                    cx="136.5"
                                    cy="37.6737"
                                    rx="37.5"
                                    ry="37.3172"
                                    fill="#00BCD4"
                                />
                                <ellipse
                                    cx="136.5"
                                    cy="38.171"
                                    rx="7"
                                    ry="6.96588"
                                    fill="white"
                                />
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M130.255 30.8841C132.068 29.0797 134.479 28.0753 137.043 28.0753C139.607 28.0753 142.018 29.085 143.831 30.8894C144.981 32.0342 145.803 33.41 146.251 34.9453H153.457V25.3068C153.457 23.0456 151.701 21.2979 149.429 21.2979H124.743C122.471 21.2979 120.543 23.0456 120.543 25.3068V34.9453H127.835C128.282 33.41 129.104 32.0289 130.255 30.8841ZM150.714 28.3933C150.714 28.9963 150.223 29.4851 149.617 29.4851H146.326C145.72 29.4851 145.229 28.9964 145.229 28.3933V25.118C145.229 24.515 145.72 24.0262 146.326 24.0262H149.617C150.223 24.0262 150.714 24.5149 150.714 25.118V28.3933Z"
                                    fill="white"
                                />
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M143.831 44.3944C142.018 46.1987 139.607 47.1818 137.043 47.1818C134.479 47.1818 132.068 46.2041 130.255 44.3998C128.445 42.5987 127.447 40.1484 127.443 37.6748H120.543V49.8722C120.543 52.1334 122.471 54.0517 124.743 54.0517H149.429C151.701 54.0517 153.457 52.1334 153.457 49.8722V37.6748H146.643C146.639 40.1484 145.641 42.5933 143.831 44.3944Z"
                                    fill="white"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
