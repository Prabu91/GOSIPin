
<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
	<span class="sr-only">Open sidebar</span>
	<svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
	<path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
	</svg>
 </button>
 
<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
<div class="h-full px-3 py-2 overflow-y-auto bg-sidebar items-center">
	<div class="items-center space-x-4">
		<a href="{{ route('dashboard') }}">
			<img src="{{ asset('images/logo-light.png') }}" width="180" class="mx-auto my-4" />
		</a>
	</div>
	<div class="font-bold text-center text-txtd space-x-4">
		<p>{{ auth()->user()->name }} - {{ auth()->user()->role }} - {{ auth()->user()->department }}</p>
	</div>
	<ul class="space-y-2 font-medium pt-4 mt-4 mx-auto border-t border-gray-200 dark:border-gray-700">
		<li>
			<a href="{{ route('dashboard') }}" class="flex p-2 text-txtl rounded-lg dark:text-txtd hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('dashboard') ? 'bg-gray-700  text-txtd' : '' }}">
				<svg class="flex-shrink-0 w-5 h-5 text-txtl transition duration-75 dark:text-txtd group-hover:text-gray-900 dark:group-hover:text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
					<path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="5 12 3 12 12 3 21 12 19 12" />  <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />  <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
				</svg>
				<span class="flex-1 ms-3 whitespace-nowrap">Dashboard</span>
			</a>
		</li>
		@if (auth()->user()->role == 'UK')	
			<li>
				<a href="{{ route('users.index') }}" class="flex p-2 text-txtl rounded-lg dark:text-txtd hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('users.index') || Request::routeIs('users.*') ? 'bg-gray-700  text-txtd' : '' }}">
					<svg class="flex-shrink-0 w-5 h-5 text-txtl transition duration-75 dark:text-txtd group-hover:text-gray-900 dark:group-hover:text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
						<path stroke="none" d="M0 0h24v24H0z"/>
						<circle cx="9" cy="7" r="4" />
						<path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
						<path d="M16 3.13a4 4 0 0 1 0 7.75" />
						<path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
					</svg>
					<span class="flex-1 ms-3 whitespace-nowrap">Users</span>
				</a>
			</li>
		@endif
		<li>
			<a href="{{ route('classificationCode.index') }}" class="flex p-2 text-txtl rounded-lg dark:text-txtd hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('classificationCode.index') || Request::routeIs('classificationCode.*') ? 'bg-gray-700  text-txtd' : '' }}">
				<svg class="flex-shrink-0 w-5 h-5 text-txtl transition duration-75 dark:text-txtd group-hover:text-gray-900 dark:group-hover:text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
					<path stroke="none" d="M0 0h24v24H0z"/>
					<path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" />
					<line x1="8" y1="8" x2="12" y2="8" />
					<line x1="8" y1="12" x2="12" y2="12" />
					<line x1="8" y1="16" x2="12" y2="16" />
				</svg>
				<span class="flex-1 ms-3 whitespace-nowrap">Kode Klasifikasi</span>
			</a>
		</li>
	</ul>
	<ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
		<li>
			<a href="{{ route('classification.index') }}" class="flex p-2 text-txtl rounded-lg dark:text-txtd hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('classification.index') || Request::routeIs('classification.create') || Request::routeIs('classification.edit') ? 'bg-gray-700  text-txtd' : '' }}">
				<svg class="flex-shrink-0 w-5 h-5 text-txtl transition duration-75 dark:text-txtd group-hover:text-gray-900 dark:group-hover:text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />  <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" /></svg>
				<span class="flex-1 ms-3 whitespace-nowrap">Klasifikasi</span>
			</a>
		</li>
		<li>
			<a href="{{ route('classification.active') }}" class="flex p-2 text-txtl rounded-lg dark:text-txtd hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('classification.active') ? 'bg-gray-700  text-txtd' : '' }}">
				<svg class="flex-shrink-0 w-5 h-5 text-txtl transition duration-75 dark:text-txtd group-hover:text-gray-900 dark:group-hover:text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />  <line x1="12" y1="10" x2="12" y2="16" />  <line x1="9" y1="13" x2="15" y2="13" /></svg>
				<span class="flex-1 ms-3 whitespace-nowrap">Active</span>
			</a>
		</li>
		<li>
			<a href="{{ route('classification.inactive') }}" class="flex p-2 text-txtl rounded-lg dark:text-txtd hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('classification.inactive') ? 'bg-gray-700  text-txtd' : '' }}">
				<svg class="flex-shrink-0 w-5 h-5 text-txtl transition duration-75 dark:text-txtd group-hover:text-gray-900 dark:group-hover:text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
				</svg>
				<span class="flex-1 ms-3 whitespace-nowrap">Inactive</span>
			</a>
		</li>
		<li>
			<a href="{{ route('labelBox.index') }}" class="flex p-2 text-txtl rounded-lg dark:text-txtd hover:bg-gray-100 dark:hover:bg-gray-700 group {{ Request::routeIs('labelBox.index')  || Request::routeIs('labelBox.*') ? 'bg-gray-700  text-txtd' : '' }}">
				<svg class="flex-shrink-0 w-5 h-5 text-txtl transition duration-75 dark:text-txtd group-hover:text-gray-900 dark:group-hover:text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3" />  <line x1="12" y1="12" x2="20" y2="7.5" />  <line x1="12" y1="12" x2="12" y2="21" />  <line x1="12" y1="12" x2="4" y2="7.5" />  <line x1="16" y1="5.25" x2="8" y2="9.75" /></svg>
				<span class="flex-1 ms-3 whitespace-nowrap">Label Box</span>
			</a>
		</li>
	</ul>
	<ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
		<li>
			<form method="POST" action="{{ route('logout') }}">
				@csrf
					<button class="flex w-full text-left p-2 text-txtl rounded-lg dark:text-txtd hover:bg-gray-100 dark:hover:bg-gray-700 group" onclick="event.preventDefault(); this.closest('form').submit();">
						<svg class="flex-shrink-0 w-5 h-6 text-txtl transition duration-75 dark:text-txtd group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3"/>
						</svg>
						<span class="flex-1 ms-3 whitespace-nowrap">Log Out</span>
					</button>
			</form>
		</li>
	</ul>
</div>
</aside>
