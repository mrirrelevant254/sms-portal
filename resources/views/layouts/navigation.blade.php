<nav x-data="{ mobileOpen: false }" class="bg-[#A0F0A0] border-b border-green-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/dashboard">
                        <span class="font-bold text-lg text-black">Student Portal</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex items-center">
                    
                    {{-- STUDENT MENUS --}}
                    @role('student')
                        <a href="{{ route('student.dashboard') }}" class="px-3 py-2 text-sm font-medium text-black hover:text-gray-600 rounded-md">Dashboard</a>

                        <!-- Finances Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center px-3 py-2 text-sm font-medium text-black hover:text-gray-600 rounded-md focus:outline-none">
                                Finances
                                <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>
                            <div x-show="open" x-transition style="display: none;" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-[#A0F0A0] ring-1 ring-black ring-opacity-5">
                                <a href="{{ route('student.fees.statement') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Fee Statement</a>
                            </div>
                        </div>

                        <!-- Academics Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center px-3 py-2 text-sm font-medium text-black hover:text-gray-600 rounded-md focus:outline-none">
                                Academics
                                <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>
                            <div x-show="open" x-transition style="display: none;" class="absolute z-50 mt-2 w-56 rounded-md shadow-lg bg-[#A0F0A0] ring-1 ring-black ring-opacity-5">
                                <a href="{{ route('student.semester-report.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Semester Reporting</a>
                                <a href="{{ route('student.units.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Unit Registration</a>
                                <a href="{{ route('student.transcript.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Provisional Transcript</a>
                                <a href="#" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Supplementary & Special Exams</a>
                                <a href="#" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Timetable</a>
                                <a href="{{ route('student.exam-card.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Exam Card</a>
                            </div>
                        </div>

                        <!-- Student Requests Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center px-3 py-2 text-sm font-medium text-black hover:text-gray-600 rounded-md focus:outline-none">
                                Student Requests
                                <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>
                            <div x-show="open" x-transition style="display: none;" class="absolute z-50 mt-2 w-56 rounded-md shadow-lg bg-[#A0F0A0] ring-1 ring-black ring-opacity-5">
                                <a href="{{ route('student.requests.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Graduation Application</a>
                                <a href="{{ route('student.requests.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Request To Defer</a>
                                <a href="{{ route('student.requests.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Request Call Off</a>
                                <a href="{{ route('student.requests.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Inter-School Transfer</a>
                                <a href="{{ route('student.requests.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Withdraw From University</a>
                                <a href="{{ route('student.requests.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Withdrawal Clearance</a>
                            </div>
                        </div>

                        <a href="{{ route('student.hostel.index') }}" class="px-3 py-2 text-sm font-medium text-black hover:text-gray-600 rounded-md">Hostel Booking</a>
                    @endrole

                    {{-- ADMIN MENUS --}}
                    @role('admin|registrar')
                        <a href="{{ route('admin.students.index') }}" class="px-3 py-2 text-sm font-medium text-black hover:text-gray-600 rounded-md">Manage Students</a>
                        <a href="{{ route('admin.requests.index') }}" class="px-3 py-2 text-sm font-medium text-black hover:text-gray-600 rounded-md">Student Requests</a>
                    @endrole

                    {{-- LECTURER MENUS --}}
                    @role('lecturer')
                        <a href="{{ route('lecturer.grades.index') }}" class="px-3 py-2 text-sm font-medium text-black hover:text-gray-600 rounded-md">Grade Entry</a>
                    @endrole
                </div>
            </div>

            <!-- Account Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center px-3 py-2 text-sm font-medium text-black hover:text-gray-600 rounded-md focus:outline-none">
                        <svg class="w-5 h-5 me-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                        Account
                        <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                    <div x-show="open" x-transition style="display: none;" class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg bg-[#A0F0A0] ring-1 ring-black ring-opacity-5">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-black hover:bg-green-300">Update Contact Details</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-left px-4 py-2 text-sm text-black hover:bg-green-300">Logout</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="mobileOpen = !mobileOpen" class="inline-flex items-center justify-center p-2 rounded-md text-black hover:text-gray-800 hover:bg-green-200 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileOpen, 'inline-flex': !mobileOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !mobileOpen, 'inline-flex': mobileOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': mobileOpen, 'hidden': !mobileOpen}" class="hidden sm:hidden bg-[#A0F0A0]">
        <div class="pt-2 pb-3 space-y-1">
            @role('student')
                <a href="{{ route('student.dashboard') }}" class="block px-4 py-2 text-base font-medium text-black hover:bg-green-300">Dashboard</a>
                <a href="{{ route('student.fees.statement') }}" class="block px-4 py-2 text-base font-medium text-black hover:bg-green-300">Fee Statement</a>
                <a href="{{ route('student.semester-report.index') }}" class="block px-4 py-2 text-base font-medium text-black hover:bg-green-300">Semester Reporting</a>
                <a href="{{ route('student.units.index') }}" class="block px-4 py-2 text-base font-medium text-black hover:bg-green-300">Unit Registration</a>
                <a href="{{ route('student.requests.index') }}" class="block px-4 py-2 text-base font-medium text-black hover:bg-green-300">Student Requests</a>
                <a href="{{ route('student.hostel.index') }}" class="block px-4 py-2 text-base font-medium text-black hover:bg-green-300">Hostel Booking</a>
            @endrole
            
            @role('admin|registrar')
                <a href="{{ route('admin.students.index') }}" class="block px-4 py-2 text-base font-medium text-black hover:bg-green-300">Manage Students</a>
                <a href="{{ route('admin.requests.index') }}" class="block px-4 py-2 text-base font-medium text-black hover:bg-green-300">Student Requests</a>
            @endrole

            @role('lecturer')
                <a href="{{ route('lecturer.grades.index') }}" class="block px-4 py-2 text-base font-medium text-black hover:bg-green-300">Grade Entry</a>
            @endrole
        </div>
    </div>
</nav>