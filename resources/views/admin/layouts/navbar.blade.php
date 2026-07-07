<header class="bg-white h-20 shadow-sm border-b border-gray-200 flex items-center justify-between px-8">

    <!-- Left -->
    <div class="flex items-center gap-5">

        <!-- Mobile Menu -->
        <button
            class="text-2xl text-slate-700 hover:text-yellow-500 transition">

            <i class="bi bi-list"></i>

        </button>

        <div>

            <h1 class="text-2xl font-bold text-slate-800">

                @yield('page-title')

            </h1>

            <p class="text-sm text-slate-500">

                Welcome back 👋

            </p>

        </div>

    </div>

    <!-- Right -->
    <div class="flex items-center gap-5">

        <!-- Language -->
        <button
            class="w-10 h-10 rounded-full bg-slate-100 hover:bg-yellow-100 transition flex items-center justify-center">

            <i class="bi bi-translate text-lg"></i>

        </button>

        <!-- Notification -->
        <button
            class="relative w-10 h-10 rounded-full bg-slate-100 hover:bg-yellow-100 transition flex items-center justify-center">

            <i class="bi bi-bell text-lg"></i>

            <span
                class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-red-500 text-white text-[10px] flex items-center justify-center">

                3

            </span>

        </button>

        <!-- Divider -->
        <div class="w-px h-10 bg-gray-300"></div>

        <!-- User -->
        <div class="flex items-center gap-3">

            <img
                src="https://ui-avatars.com/api/?name=Admin&background=D4AF37&color=fff"
                class="w-11 h-11 rounded-full border-2 border-yellow-400"
                alt="Admin">

            <div class="hidden md:block">

                <h3 class="font-semibold text-slate-800">

                    Administrator

                </h3>

                <p class="text-xs text-slate-500">

                    Super Admin

                </p>

            </div>

            <i class="bi bi-chevron-down text-gray-500"></i>

        </div>

    </div>

</header>