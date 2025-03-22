@props(['user'])

<nav class="bg-gray-800">
    <div class="lg:px-8 max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex h-16 justify-between items-center">
            <div class="flex items-center">
                <div class="shrink-0">
                    <img class="size-8" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                </div>
                <div class="hidden md:block">
                    <div class="flex items-baseline ml-10 space-x-4">
                        <a href="#" class="bg-gray-900 rounded-md text-sm text-white font-medium px-3 py-2">Dashboard</a>
                        <a href="#" class="rounded-md text-gray-300 text-sm font-medium hover:bg-gray-700 hover:text-white px-3 py-2">Team</a>
                        <a href="#" class="rounded-md text-gray-300 text-sm font-medium hover:bg-gray-700 hover:text-white px-3 py-2">Projects</a>
                        <a href="#" class="rounded-md text-gray-300 text-sm font-medium hover:bg-gray-700 hover:text-white px-3 py-2">Calendar</a>
                        <a href="#" class="rounded-md text-gray-300 text-sm font-medium hover:bg-gray-700 hover:text-white px-3 py-2">Reports</a>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="flex items-center md:ml-6 ml-4">
                    <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white">
                        <span class="sr-only">View notifications</span>
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                    </button>
                    <div class="ml-3 relative">
                        <button type="button" class="flex bg-gray-800 rounded-full text-sm items-center">
                            <span class="sr-only">Open user menu</span>
                            <img class="rounded-full size-8" src="{{ $user->profile_photo_url ?? 'https://via.placeholder.com/40' }}" alt="User Profile">
                        </button>
                        <div class="bg-white rounded-md shadow-lg w-48 absolute mt-2 right-0 ring-1 ring-black/5 z-10">
                            <a href="#" class="text-gray-700 text-sm block px-4 py-2">Your Profile</a>
                            <a href="/admin" class="text-gray-700 text-sm block px-4 py-2">Admin</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-700 text-sm block w-full text-left px-4 py-2">Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>