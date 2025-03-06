<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'E-Book Motivasi Al-Qur\'an') }}</title>

        <link rel="icon" type="image/x-icon" href="/assets/img/small-logos/app-logo.webp">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet"
        />

        <link rel="stylesheet" type="text/css" href="/assets/css/landing.css" />
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
        <div class="px-4 container mx-auto flex gap-24">
          <img src="/assets/img/landing/logo.png" class="w-32 aspect-square object-cover my-auto" alt="" />

          <div class="my-auto me-auto">
            <ul class="hidden md:flex gap-8 font-semibold text-xl">
              <li><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#testimoni">Testimoni</a></li>
              <li><a href="#faq">FAQ</a></li>
              <li><a href="#download">Download</a></li>
            </ul>
          </div>

          <svg xmlns="http://www.w3.org/2000/svg" class="w-28" viewBox="0 0 170 75" fill="none">
            <circle opacity="0.24" cx="37.5" cy="37.5" r="37.5" fill="white" />
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M41.3333 28.6667V23.7057C41.3333 21.4661 41.8479 20.3333 45.4635 20.3333H50V12H42.4302C33.1542 12 30.0938 16.0885 30.0938 23.1068V28.6667H24V37H30.0938V62H41.3333V37H48.9708L50 28.6667H41.3333Z"
              fill="white"
            />
            <circle opacity="0.235096" cx="132.5" cy="37.5" r="37.5" fill="#E1BEE7" />
            <ellipse cx="132.457" cy="37.5" rx="8" ry="8.5" fill="#E1BEE7" />
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
        <div class="grid lg:grid-cols-2 gap-4">
          <div class="mt-16 md:mt-0 py-8">
            <h1 class="text-3xl md:text-4xl xl:text-5xl font-bold leading-snug">
              Temukan Ketenangan & <br />
              Motivasi dari <span class="text-primary">Al-Qur'an</span>
            </h1>

            <p class="my-8 text-lg md:text-xl text-secondary leading-relaxed">
              Dapatkan inspirasi harian dari ayat-ayat Al-Qur'an yang menyentuh hati dan memperkuat
              iman.
            </p>

            <ul class="list-disc px-5 font-semibold text-secondary">
              <li class="mb-2">Sebagai penyejuk hati, pengingat, dan motivasi bagi kaum Muslim.</li>
              <li class="mb-2">
                Lebih dari 200 motivasi dan pengingat Islami dalam satu aplikasi!
              </li>
              <li class="mb-2">Hanya bayar sekali untuk akses penuh!</li>
              <li class="mb-2">Download sekarang & mulai perjalanan spiritual Anda!</li>
            </ul>

            <div class="mt-24 flex justify-center">
              <img src="/assets/img/landing/google-play.png" class="w-48" alt="" />
            </div>
          </div>
          <div class="flex">
            <img src="/assets/img/landing/hero.png" class="w-full m-auto" alt="" />
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="px-4 container mx-auto mb-8">
        <div class="grid sm:grid-cols-3 gap-24 sm:gap-0">
          <div class="flex flex-col items-center">
            <h2 class="text-primary text-4xl font-semibold mb-2">+200M</h2>
            <div class="flex items-center justify-center gap-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 m-auto"
                viewBox="0 0 56 53"
                fill="none"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M20.2298 42.0643L18.7831 43.4949L28.0748 52.7059L37.3666 43.4949L35.9198 42.0643L29.0975 48.8157V18.4345H27.0521V48.8157L20.2298 42.0643Z"
                  fill="black"
                  fill-opacity="0.54"
                />
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M45.9225 14.858C45.9225 14.7075 45.9474 14.5694 45.9474 14.4188C45.9474 6.4502 39.3497 0 31.3799 0C25.6303 0 20.6788 3.36314 18.359 8.20706C17.3488 7.7051 16.2263 7.41647 15.0165 7.41647C11.3247 7.41647 8.26904 10.3404 7.67037 13.8541C3.28017 15.36 0.112244 19.3004 0.112244 24.1945C0.112244 30.3561 5.11358 35.3882 11.2873 35.3882H22.6993V33.3804H11.3871C6.28596 33.3804 2.13273 29.2141 2.13273 24.1318C2.13273 20.1914 4.65211 16.9161 8.39376 15.6361L9.44142 15.2847L9.6285 14.1929C10.0775 11.52 12.3848 9.32392 15.1038 9.32392C15.9644 9.32392 16.8125 9.52471 17.5857 9.91373L19.2695 10.7545L20.0802 9.04784C22.1506 4.73098 26.5782 1.9451 31.355 1.9451C38.2521 1.9451 43.9394 7.31608 43.9394 14.1929C43.9394 15.8369 43.9145 16.7153 43.9145 16.7153L45.8102 16.7278C50.3875 16.7906 53.992 20.4925 53.992 25.0604C53.992 29.6157 50.2753 33.3553 45.698 33.3804L45.2989 33.3929H33.1759V35.4008H45.7728C51.3853 35.4008 55.9875 30.7325 55.9875 25.098C55.9875 19.451 51.5724 14.8706 45.9225 14.858Z"
                  fill="black"
                  fill-opacity="0.54"
                />
              </svg>
              <p class="text-secondary text-center text-2xl">Downloads</p>
            </div>
          </div>
          <div class="border-0 border-[#d1c4e9] sm:border-l-2 flex flex-col items-center">
            <h2 class="text-primary text-4xl font-semibold mb-2">+480M</h2>
            <div class="flex items-center justify-center gap-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 m-auto"
                viewBox="0 0 58 58"
                fill="none"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M40.5997 17.5757L23.1493 35.1879L16.5495 28.5746L14.0606 31.0686L21.8909 38.9149C22.2405 39.2652 22.7159 39.5454 23.1353 39.5454C23.5548 39.5454 24.0162 39.2652 24.3658 38.9289L43.0606 20.0978L40.5997 17.5757Z"
                  fill="black"
                  fill-opacity="0.54"
                />
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M29 0C12.9803 0 0 12.9803 0 29C0 45.0197 12.9803 58 29 58C45.0197 58 58 45.0197 58 29C58 12.9803 45.0197 0 29 0ZM29 55.588C14.3466 55.588 2.41202 43.6673 2.41202 29C2.41202 14.3466 14.3327 2.41202 29 2.41202C43.6534 2.41202 55.588 14.3327 55.588 29C55.588 43.6534 43.6534 55.588 29 55.588Z"
                  fill="black"
                  fill-opacity="0.54"
                />
              </svg>
              <p class="text-secondary text-center text-2xl">Transactions</p>
            </div>
          </div>
          <div class="border-0 border-[#d1c4e9] sm:border-l-2 flex flex-col items-center">
            <h2 class="text-primary text-4xl font-semibold mb-2">+180M</h2>
            <div class="flex items-center justify-center gap-2">
              <svg
                viewBox="0 0 56 54"
                class="w-6 m-auto"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M56 20.9182H34.575L28 0.982758L21.425 20.9182H0L17.525 33.1852L10.7 53.1207L28 40.766L45.3 53.1207L38.4625 33.1852L56 20.9182ZM41.325 47.7578L28 38.2349L14.675 47.7578L20 32.4084L6.5 23.0483H22.875L28 7.59867L33.125 23.0483H49.5L36 32.3958L41.325 47.7578Z"
                  fill="black"
                />
              </svg>
              <p class="text-secondary text-center text-2xl">Ratings</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="relative" id="about">
      <img
        src="/assets/img/landing/feature-bg.svg"
        class="overflow-hidden w-full -z-50 absolute -bottom-[10%] left-0 right-0"
        alt=""
      />

      <div class="px-4 container mx-auto">
        <div class="py-24">
          <h2 class="text-center font-semibold text-3xl md:text-4xl xl:text-5xl mb-6">
            Kenapa Harus Menggunakan Aplikasi Ini?
          </h2>
          <div class="flex">
            <div
              class="w-20 h-2 rounded-md mx-auto"
              style="background: linear-gradient(169deg, #b2ebf2 -58.33%, #d1c4e9 60.57%)"
            ></div>
          </div>
        </div>

        <div class="grid lg:grid-cols-2 my-auto gap-8">
          <div class="flex p-8">
            <img src="/assets/img/landing/feature-1.png" class="w-full m-auto" alt="" />
          </div>
          <div class="py-8 flex flex-col justify-center">
            <h4 class="text-3xl md:text-4xl font-bold leading-snug">
              Motivasi dan Pengingat Islami yang Terpercaya
            </h4>

            <p class="my-8 text-xl leading-relaxed">
              Semua kutipan dalam aplikasi diambil <strong>langsung dari Al-Qur'an</strong>,
              sehingga terjamin kebenarannya.
            </p>
          </div>
        </div>

        <div class="grid lg:grid-cols-2 my-auto gap-8">
          <div class="lg:order-2 flex p-8">
            <img src="/assets/img/landing/feature-2.png" class="w-full m-auto" alt="" />
          </div>
          <div class="py-8 flex flex-col justify-center">
            <h4 class="text-3xl md:text-4xl font-bold leading-snug">
              Panduan Menghadapi Kehidupan Sehari-hari
            </h4>

            <p class="lg:order-1 my-8 text-xl leading-relaxed">
              Dapatkan motivasi Islami yang relevan dengan berbagai kondisi hidup:
              <strong>kesabaran, rezeki, semangat, kebahagiaan, dan banyak lagi.</strong>
            </p>
          </div>
        </div>

        <div class="grid lg:grid-cols-2 my-auto gap-8">
          <div class="flex p-8">
            <img src="/assets/img/landing/feature-1.png" class="w-full m-auto" alt="" />
          </div>
          <div class="py-8 flex flex-col justify-center">
            <h4 class="text-3xl md:text-4xl font-bold leading-snug">Praktis & Menarik</h4>

            <p class="my-8 text-xl leading-relaxed">
              Aplikasi dikemas dalam desain <strong>modern dan elegan</strong>, mudah digunakan
              kapan saja dan di mana saja.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section>
      <img src="/assets/img/landing/app-image.png" class="w-full" alt="" />
    </section>

    <section class="relative py-16" id="testimoni">
      <img
        src="/assets/img/landing/testi-bg.svg"
        class="overflow-hidden w-full -z-50 absolute -bottom-[30%] left-0 right-0"
        alt=""
      />

      <div class="px-4 container mx-auto">
        <div class="py-24">
          <h2 class="text-center font-semibold text-3xl md:text-4xl xl:text-5xl mb-6">
            Testimonials
          </h2>
          <div class="flex">
            <div
              class="w-20 h-2 rounded-md mx-auto"
              style="background: linear-gradient(169deg, #b2ebf2 -58.33%, #d1c4e9 60.57%)"
            ></div>
          </div>
        </div>

        <div class="flex">
          <blockquote class="max-w-[600px] italic text-center text-lg sm:text-xl mx-auto mb-12">
            “Setiap kali saya merasa gelisah, saya membuka aplikasi ini. Pesannya selalu pas dengan
            kondisi saya. MasyaAllah!”
          </blockquote>
        </div>

        <p class="text-lg sm:text-xl text-[#673AB7] text-center">
          <strong>Rina S.</strong>, Mahasiswi
        </p>

        <div class="py-6 my-12 flex gap-1 md:gap-4 xl:gap-8 justify-center items-center">
          <img
            src="/assets/img/landing/testi-bg.svg"
            style="object-fit: cover"
            class="hidden md:block overflow-hidden w-20 aspect-square rounded-full border-6 border-white"
            alt=""
          />
          <img
            src="/assets/img/landing/testi-bg.svg"
            style="object-fit: cover"
            class="overflow-hidden w-20 aspect-square rounded-full border-6 border-white"
            alt=""
          />
          <img
            src="/assets/img/landing/testi-bg.svg"
            style="object-fit: cover"
            class="overflow-hidden w-20 aspect-square rounded-full border-6 border-white"
            alt=""
          />
          <img
            src="/assets/img/landing/testi-bg.svg"
            style="object-fit: cover"
            class="overflow-hidden w-30 aspect-square rounded-full border-6 border-white"
            alt=""
          />
          <img
            src="/assets/img/landing/testi-bg.svg"
            style="object-fit: cover"
            class="overflow-hidden w-20 aspect-square rounded-full border-6 border-white"
            alt=""
          />
          <img
            src="/assets/img/landing/testi-bg.svg"
            style="object-fit: cover"
            class="overflow-hidden w-20 aspect-square rounded-full border-6 border-white"
            alt=""
          />
          <img
            src="/assets/img/landing/testi-bg.svg"
            style="object-fit: cover"
            class="hidden md:block overflow-hidden w-20 aspect-square rounded-full border-6 border-white"
            alt=""
          />
        </div>
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
            <h2 class="font-semibold text-3xl md:text-4xl xl:text-5xl mb-16">FAQ</h2>

            <div
              class="w-20 h-2 rounded-md"
              style="background: linear-gradient(169deg, #b2ebf2 -58.33%, #d1c4e9 60.57%)"
            ></div>
          </div>

          <div class="grid lg:grid-cols-2 my-auto gap-8">
            <div class="flex p-8">
              <img src="/assets/img/landing/faq.png" class="w-[80%] mx-auto mb-auto" alt="" />
            </div>
            <div class="min-h-svh">
              <!-- component -->
              <div class="bg-white rounded-2xl shadow-2xl">
                <div
                  class="rounded-t-xl bg-primary group flex flex-col gap-2 px-8 py-8"
                  tabindex="1"
                >
                  <div class="flex items-center justify-between">
                    <span class="font-semibold text-lg sm:text-xl text-white"> FAQ </span>
                    <img
                    alt=""
                      src="/assets/img/landing/arrow.svg"
                      class="w-4 transition-all duration-500 group-focus:-rotate-180"
                    />
                  </div>
                </div>

                <div class="group flex flex-col gap-2 px-8 py-8" tabindex="1">
                  <div class="flex cursor-pointer items-center justify-between">
                    <span class="font-semibold text-lg sm:text-xl"> Apa judul aplikasi ini? </span>
                    <img
                    alt=""
                      src="/assets/img/landing/arrow.svg"
                      class="w-4 transition-all duration-500 group-focus:-rotate-180"
                    />
                  </div>
                  <div
                    class="invisible h-auto max-h-0 items-center opacity-0 transition-all group-focus:visible group-focus:max-h-screen group-focus:opacity-100 group-focus:duration-1000"
                  >
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </div>
                </div>

                <div class="group flex flex-col gap-2 px-8 py-8" tabindex="2">
                  <div class="flex cursor-pointer items-center justify-between">
                    <span class="font-semibold text-lg sm:text-xl">
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
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </div>
                </div>

                <div class="group flex flex-col gap-2 px-8 py-8" tabindex="3">
                  <div class="flex cursor-pointer items-center justify-between">
                    <span class="font-semibold text-lg sm:text-xl">
                      Apa bedanya dengan aplikasi motivasi yang lain?
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
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </div>
                </div>

                <div class="group flex flex-col gap-2 px-8 py-8" tabindex="4">
                  <div class="flex cursor-pointer items-center justify-between">
                    <span class="font-semibold text-lg sm:text-xl">
                      Apa manfaatnya jika membaca isi aplikasi ini?
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
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </div>
                </div>

                <div class="rounded-b-xl group flex flex-col gap-2 px-8 py-8" tabindex="5">
                  <div class="flex cursor-pointer items-center justify-between">
                    <span class="font-semibold text-lg sm:text-xl"
                      >Apakah aplikasi ini gratis?
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
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <footer class="relative pt-32">
        <div class="px-4 container mx-auto py-8">
          <div class="pb-12 xl:pb-32">
            <h5 class="text-3xl md:text-4xl font-bold mb-6 text-white text-center">
              Apalagi yang kamu tunggu? Download Sekarang
            </h5>

            <div class="my-24 flex justify-center" id="download">
              <img src="/assets/img/landing/google-play.png" class="w-48" alt="" />
            </div>
          </div>

          <div class="max-w-[300px] text-white">
            <h6 class="text-xl font-bold mb-6">Motivasiislami.com</h6>
            <p class="mb-6">
              Jl Kebenaran no 134, Bla bla, Bla bla,Bla bla bla, RT RW Bla bla bla, bla bla. D.I.
              Yogyakarta, Indonesia
            </p>

            <div>
              <svg class="w-30" viewBox="0 0 174 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="37.5" cy="37.6737" rx="37.5" ry="37.3172" fill="#00BCD4" />
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M41.3333 28.8833V23.9465C41.3333 21.7179 41.8479 20.5906 45.4635 20.5906H50V12.2979H42.4302C33.1542 12.2979 30.0938 16.3665 30.0938 23.3505V28.8833H24V37.176H30.0938V62.0542H41.3333V37.176H48.9708L50 28.8833H41.3333Z"
                  fill="white"
                />
                <ellipse cx="136.5" cy="37.6737" rx="37.5" ry="37.3172" fill="#00BCD4" />
                <ellipse cx="136.5" cy="38.171" rx="7" ry="6.96588" fill="white" />
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
