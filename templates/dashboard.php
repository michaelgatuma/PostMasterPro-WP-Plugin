<style>
    img {
        border-style: none !important;
    }

    @keyframes spinner {
        to {
            transform: rotate(360deg);
        }
    }

    .spinner:before {
        content: '';
        box-sizing: border-box;
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin-top: -10px;
        margin-left: -10px;
        border-radius: 50%;
        border: 2px solid transparent !important;
        border-top-color: #07d !important;
        border-bottom-color: #07d !important;
        animation: spinner .8s ease infinite;
    }
</style>
<?php
$dashboard = new PostMasterPro_Dashboard( '1.0' );
$posts     = $dashboard->get_published_posts();
?>
<div x-data="postMasterApp()" x-init="fetchUser()" class="wrap postmasterpro-dashboard">
	<div class="mx-2 mb-2">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	</div>
	<!-- menubar -->
	<div class="space-y-5 mb-6 hidden">
		<div class="overflow-hidden rounded-xl border border-gray-100 bg-gray-50 p-1">
			<ul class="flex items-center gap-2 text-sm font-medium">
				<li class="flex-1">
					<a
						href="#"
						class="text-gra relative flex items-center justify-center gap-2 rounded-lg bg-white px-3 py-2 shadow hover:bg-white hover:text-gray-700"
					>
						Dashboard</a
					>
				</li>
				<li class="flex-1">
					<a
						href="#"
						class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-white hover:text-gray-700 hover:shadow"
					>
						Cron Jobs</a
					>
				</li>
				<li class="flex-1">
					<a
						href="#"
						class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-white hover:text-gray-700 hover:shadow"
					>
						Notifications
						<span
							class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500 hidden"> 0 </span></a
					>
				</li>
				<li class="flex-1">
					<a
						href="#"
						class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-white hover:text-gray-700 hover:shadow"
					>
						Account</a
					>
				</li>
				<li class="flex-1">
					<a
						href="#"
						class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-white hover:text-gray-700 hover:shadow"
					>
						API</a
					>
				</li>
			</ul>
		</div>
	</div>

	<!-- component -->
	<div class="bg-white relative rounded-xl lg:py-5">
		<!-- alerts -->
		<?php if ( isset( $_GET['login'] ) ): ?>
			<div class='my-6 space-y-6 w-full'>
				<!-- Display login and registration messages -->
				<?php if ( $_GET['login'] === 'success' ): ?>
					<div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3"
					     role="alert">
						<p class="font-bold">Awesome!</p>
						<p class="text-sm">You have been logged in successfully.</p>
					</div>
				<?php elseif ( $_GET['login'] === 'error' ): ?>
					<div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
						<p class="font-bold">Whoops!</p>
						<p class="text-sm">Login error. Are you sure you entered the correct credentials?</p>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<template x-if="errorMessage">
			<div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-10 py-3" role="alert">
				<p class="font-bold">Whoops!</p>
				<p class="text-sm" x-text="errorMessage"></p>
			</div>
		</template>
		<template x-if="successMessage">
			<div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-10 py-3"
			     role="alert">
				<p class="font-bold">Awesome!</p>
				<p class="text-sm" x-text="successMessage"></p>
			</div>
		</template>
		<div class="flex flex-col items-center justify-between py-0 px-0 my-0 mr-auto ml-auto xl:px-5 lg:flex-row">

			<?php
			if ( $dashboard->is_user_logged_in() ) :
				?>

				<!-- Content for logged-in users -->
				<div class="w-full">
					<div class="flex w-full justify-between mb-4">
						<div class="space-y-4">

							<h2 class="text-2xl">Hello, <span x-text="userName">friend</span>!</h2>

							<p class="text-lg max-w-7xl">
								Welcome to post farm. I am your Post Master. Here you can monitor your post worker bees
								here. You can also create more hives and get notifications when the jobs fail.
							</p>

							<div class="flex gap-4">

								<div
									class="relative w-full p-4 overflow-hidden bg-white shadow-lg rounded-xl md:w-72 dark:bg-gray-800 border">
									<div class="block w-full h-full">
										<div class="flex items-center w-full">
											<a href="#" class="relative block">
												<img alt="profil"
												     src="https://cdn-icons-png.flaticon.com/512/179/179546.png"
												     class="mx-auto object-cover rounded-full h-10 w-10 "/>
											</a>
											<div class="flex flex-col ml-2 flex-grow">
										<span class="dark:text-white">
											Worker: ups1
										</span>
												<span class="text-sm text-green-400 dark:text-gray-300">
											Running
										</span>
											</div>
											<div>
												<button
													class="flex text-xs items-center px-2 py-1 transition ease-in duration-200 uppercase rounded-full hover:bg-gray-800 hover:text-white text-green-500 border border-green-700 focus:outline-none">
													<svg xmlns="http://www.w3.org/2000/svg" fill="none"
													     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
													     class="w-4 h-4">
														<path stroke-linecap="round" stroke-linejoin="round"
														      d="M5.636 5.636a9 9 0 1012.728 0M12 3v9"/>
													</svg>
												</button>
											</div>
										</div>
										<div class="flex items-center justify-between my-2">
											<p class="text-sm text-gray-300">
												<?php echo $posts->found_posts ?> /5000 posts completed
											</p>
										</div>
										<div class="w-full h-2 bg-blue-200 rounded-full">
											<div
												style="width: <?php echo ( 100 * $posts->found_posts ) / 5000 ?>%;"
												class="h-full text-xs text-center text-white bg-blue-600 rounded-full">
											</div>
										</div>
									</div>
								</div>
							</div>

							<button x-on:click="fetchQuestion"
							        class="bg-green-600 text-white px-4 py-2 rounded-lg hidden">
								Publish Random Question
							</button>


						</div>
						<div class="space-y-4">

							<div class="p-4 bg-green-50 border shadow-lg rounded-2xl w-36 dark:bg-gray-800 w-auto">
								<div class="flex items-center">
							        <span class="relative w-4 h-4 p-2 bg-green-500 rounded-full">
							            <svg width="20" fill="currentColor" height="20"
							                 class="absolute h-2 text-white transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
							                 viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
							                <path
								                d="M1362 1185q0 153-99.5 263.5t-258.5 136.5v175q0 14-9 23t-23 9h-135q-13 0-22.5-9.5t-9.5-22.5v-175q-66-9-127.5-31t-101.5-44.5-74-48-46.5-37.5-17.5-18q-17-21-2-41l103-135q7-10 23-12 15-2 24 9l2 2q113 99 243 125 37 8 74 8 81 0 142.5-43t61.5-122q0-28-15-53t-33.5-42-58.5-37.5-66-32-80-32.5q-39-16-61.5-25t-61.5-26.5-62.5-31-56.5-35.5-53.5-42.5-43.5-49-35.5-58-21-66.5-8.5-78q0-138 98-242t255-134v-180q0-13 9.5-22.5t22.5-9.5h135q14 0 23 9t9 23v176q57 6 110.5 23t87 33.5 63.5 37.5 39 29 15 14q17 18 5 38l-81 146q-8 15-23 16-14 3-27-7-3-3-14.5-12t-39-26.5-58.5-32-74.5-26-85.5-11.5q-95 0-155 43t-60 111q0 26 8.5 48t29.5 41.5 39.5 33 56 31 60.5 27 70 27.5q53 20 81 31.5t76 35 75.5 42.5 62 50 53 63.5 31.5 76.5 13 94z">
							                </path>
							            </svg>
							        </span>
									<p class="ml-2 text-gray-700 text-md dark:text-gray-50">
										Tokens
									</p>
								</div>
								<div class="flex flex-col justify-start">
									<p class="my-4 text-4xl font-bold text-left text-gray-800 dark:text-white">
										0
									</p>
									<div class="relative h-2 bg-gray-200 rounded w-28">
										<div class="absolute top-0 left-0 w-2/3 h-2 bg-green-500 rounded">
										</div>
									</div>
								</div>
							</div>

							<div class="space-y-2">
								<button disabled x-on:click="alert('Buying tokens will be available soon')"
								        class="bg-gray-300 cursor-default text-white px-4 py-2 rounded-lg w-full text-center">
									Buy Tokens
								</button>
								<button x-on:click="logout"
								        class="bg-red-600 hover:bg-red-700 transition-all text-white px-4 py-2 rounded-lg w-full text-center shadow-sm">
									Disconnect
								</button>
							</div>
						</div>
					</div>
					<!-- ... -->

				</div>

			<?php else : ?>

				<!-- authentication -->
				<div class="flex flex-col items-center w-full pt-5 pr-10 pb-4 pl-10 lg:pt-4 lg:flex-row">
					<div class="w-full bg-cover relative max-w-md lg:max-w-2xl lg:w-7/12">
						<div class="flex flex-col items-center justify-center w-full h-full relative lg:pr-10">
							<img
								src="https://res.cloudinary.com/macxenon/image/upload/v1631570592/Run_-_Health_qcghbu.png"
								class="btn-" alt="macxenon image"/>
						</div>
					</div>
					<!-- login -->
					<div class="w-full mt-20 mr-0 mb-0 ml-0 relative z-10 max-w-2xl lg:mt-0 lg:w-5/12">
						<div
							class="flex flex-col items-start justify-start pt-10 pr-10 pb-10 pl-10 bg-white shadow-2xl rounded-xl relative z-10">
							<p class="w-full text-4xl font-medium text-center leading-snug font-serif">Login to your
								account</p>
							<form x-on:submit.prevent="login" class="w-full">
								<input type="hidden" name="action" value="postmasterpro_register">
								<div class="w-full mt-6 mr-0 mb-0 ml-0 relative space-y-8">
									<div class="relative">
										<p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
											Email</p>
										<input required x-model="email" placeholder="i.e michael@doex.com" type="email"
										       autocomplete="email"
										       class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"/>
									</div>
									<div class="relative">
										<p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
											Password</p>
										<input required x-model="password" placeholder="********" type="password"
										       autocomplete="current-password"
										       class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"/>
									</div>
									<div class="relative">
										<button type="submit"
										        class="w-full inline-block pt-4 pr-5 pb-4 pl-5 text-xl font-medium text-center text-white bg-indigo-500 rounded-lg transition duration-200 hover:text-white hover:bg-indigo-600 ease"
										        x-bind:disabled="isLoading">
											<span x-show="isLoading||true" class="spinner"></span>
											<span x-text="isLoading?'Please wait...':'Login'"></span>
										</button>
									</div>
								</div>
							</form>
						</div>
						<svg viewbox="0 0 91 91"
						     class="absolute top-0 left-0 z-0 w-32 h-32 -mt-12 -ml-12 text-yellow-300 fill-current">
							<g stroke="none" strokewidth="1" fillrule="evenodd">
								<g fillrule="nonzero">
									<g>
										<g>
											<circle
												cx="3.261" cy="3.445" r="2.72"/>
											<circle cx="15.296" cy="3.445" r="2.719"/>
											<circle cx="27.333" cy="3.445"
											        r="2.72"/>
											<circle cx="39.369" cy="3.445" r="2.72"/>
											<circle cx="51.405" cy="3.445" r="2.72"/>
											<circle cx="63.441"
											        cy="3.445" r="2.72"/>
											<circle cx="75.479" cy="3.445" r="2.72"/>
											<circle cx="87.514" cy="3.445" r="2.719"/>
										</g>
										<g
											transform="translate(0 12)">
											<circle cx="3.261" cy="3.525" r="2.72"/>
											<circle cx="15.296" cy="3.525"
											        r="2.719"/>
											<circle cx="27.333" cy="3.525" r="2.72"/>
											<circle cx="39.369" cy="3.525" r="2.72"/>
											<circle
												cx="51.405" cy="3.525" r="2.72"/>
											<circle cx="63.441" cy="3.525" r="2.72"/>
											<circle cx="75.479" cy="3.525"
											        r="2.72"/>
											<circle cx="87.514" cy="3.525" r="2.719"/>
										</g>
										<g transform="translate(0 24)">
											<circle cx="3.261"
											        cy="3.605" r="2.72"/>
											<circle cx="15.296" cy="3.605" r="2.719"/>
											<circle cx="27.333" cy="3.605" r="2.72"/>
											<circle
												cx="39.369" cy="3.605" r="2.72"/>
											<circle cx="51.405" cy="3.605" r="2.72"/>
											<circle cx="63.441" cy="3.605"
											        r="2.72"/>
											<circle cx="75.479" cy="3.605" r="2.72"/>
											<circle cx="87.514" cy="3.605" r="2.719"/>
										</g>
										<g
											transform="translate(0 36)">
											<circle cx="3.261" cy="3.686" r="2.72"/>
											<circle cx="15.296" cy="3.686"
											        r="2.719"/>
											<circle cx="27.333" cy="3.686" r="2.72"/>
											<circle cx="39.369" cy="3.686" r="2.72"/>
											<circle
												cx="51.405" cy="3.686" r="2.72"/>
											<circle cx="63.441" cy="3.686" r="2.72"/>
											<circle cx="75.479" cy="3.686"
											        r="2.72"/>
											<circle cx="87.514" cy="3.686" r="2.719"/>
										</g>
										<g transform="translate(0 49)">
											<circle cx="3.261"
											        cy="2.767" r="2.72"/>
											<circle cx="15.296" cy="2.767" r="2.719"/>
											<circle cx="27.333" cy="2.767" r="2.72"/>
											<circle
												cx="39.369" cy="2.767" r="2.72"/>
											<circle cx="51.405" cy="2.767" r="2.72"/>
											<circle cx="63.441" cy="2.767"
											        r="2.72"/>
											<circle cx="75.479" cy="2.767" r="2.72"/>
											<circle cx="87.514" cy="2.767" r="2.719"/>
										</g>
										<g
											transform="translate(0 61)">
											<circle cx="3.261" cy="2.846" r="2.72"/>
											<circle cx="15.296" cy="2.846"
											        r="2.719"/>
											<circle cx="27.333" cy="2.846" r="2.72"/>
											<circle cx="39.369" cy="2.846" r="2.72"/>
											<circle
												cx="51.405" cy="2.846" r="2.72"/>
											<circle cx="63.441" cy="2.846" r="2.72"/>
											<circle cx="75.479" cy="2.846"
											        r="2.72"/>
											<circle cx="87.514" cy="2.846" r="2.719"/>
										</g>
										<g transform="translate(0 73)">
											<circle cx="3.261"
											        cy="2.926" r="2.72"/>
											<circle cx="15.296" cy="2.926" r="2.719"/>
											<circle cx="27.333" cy="2.926" r="2.72"/>
											<circle
												cx="39.369" cy="2.926" r="2.72"/>
											<circle cx="51.405" cy="2.926" r="2.72"/>
											<circle cx="63.441" cy="2.926"
											        r="2.72"/>
											<circle cx="75.479" cy="2.926" r="2.72"/>
											<circle cx="87.514" cy="2.926" r="2.719"/>
										</g>
										<g
											transform="translate(0 85)">
											<circle cx="3.261" cy="3.006" r="2.72"/>
											<circle cx="15.296" cy="3.006"
											        r="2.719"/>
											<circle cx="27.333" cy="3.006" r="2.72"/>
											<circle cx="39.369" cy="3.006" r="2.72"/>
											<circle
												cx="51.405" cy="3.006" r="2.72"/>
											<circle cx="63.441" cy="3.006" r="2.72"/>
											<circle cx="75.479" cy="3.006"
											        r="2.72"/>
											<circle cx="87.514" cy="3.006" r="2.719"/>
										</g>
									</g>
								</g>
							</g>
						</svg>
						<svg viewbox="0 0 91 91"
						     class="absolute bottom-0 right-0 z-0 w-32 h-32 -mb-12 -mr-12 text-indigo-500 fill-current">
							<g stroke="none" strokewidth="1" fillrule="evenodd">
								<g fillrule="nonzero">
									<g>
										<g>
											<circle
												cx="3.261" cy="3.445" r="2.72"/>
											<circle cx="15.296" cy="3.445" r="2.719"/>
											<circle cx="27.333" cy="3.445"
											        r="2.72"/>
											<circle cx="39.369" cy="3.445" r="2.72"/>
											<circle cx="51.405" cy="3.445" r="2.72"/>
											<circle cx="63.441"
											        cy="3.445" r="2.72"/>
											<circle cx="75.479" cy="3.445" r="2.72"/>
											<circle cx="87.514" cy="3.445" r="2.719"/>
										</g>
										<g
											transform="translate(0 12)">
											<circle cx="3.261" cy="3.525" r="2.72"/>
											<circle cx="15.296" cy="3.525"
											        r="2.719"/>
											<circle cx="27.333" cy="3.525" r="2.72"/>
											<circle cx="39.369" cy="3.525" r="2.72"/>
											<circle
												cx="51.405" cy="3.525" r="2.72"/>
											<circle cx="63.441" cy="3.525" r="2.72"/>
											<circle cx="75.479" cy="3.525"
											        r="2.72"/>
											<circle cx="87.514" cy="3.525" r="2.719"/>
										</g>
										<g transform="translate(0 24)">
											<circle cx="3.261"
											        cy="3.605" r="2.72"/>
											<circle cx="15.296" cy="3.605" r="2.719"/>
											<circle cx="27.333" cy="3.605" r="2.72"/>
											<circle
												cx="39.369" cy="3.605" r="2.72"/>
											<circle cx="51.405" cy="3.605" r="2.72"/>
											<circle cx="63.441" cy="3.605"
											        r="2.72"/>
											<circle cx="75.479" cy="3.605" r="2.72"/>
											<circle cx="87.514" cy="3.605" r="2.719"/>
										</g>
										<g
											transform="translate(0 36)">
											<circle cx="3.261" cy="3.686" r="2.72"/>
											<circle cx="15.296" cy="3.686"
											        r="2.719"/>
											<circle cx="27.333" cy="3.686" r="2.72"/>
											<circle cx="39.369" cy="3.686" r="2.72"/>
											<circle
												cx="51.405" cy="3.686" r="2.72"/>
											<circle cx="63.441" cy="3.686" r="2.72"/>
											<circle cx="75.479" cy="3.686"
											        r="2.72"/>
											<circle cx="87.514" cy="3.686" r="2.719"/>
										</g>
										<g transform="translate(0 49)">
											<circle cx="3.261"
											        cy="2.767" r="2.72"/>
											<circle cx="15.296" cy="2.767" r="2.719"/>
											<circle cx="27.333" cy="2.767" r="2.72"/>
											<circle
												cx="39.369" cy="2.767" r="2.72"/>
											<circle cx="51.405" cy="2.767" r="2.72"/>
											<circle cx="63.441" cy="2.767"
											        r="2.72"/>
											<circle cx="75.479" cy="2.767" r="2.72"/>
											<circle cx="87.514" cy="2.767" r="2.719"/>
										</g>
										<g
											transform="translate(0 61)">
											<circle cx="3.261" cy="2.846" r="2.72"/>
											<circle cx="15.296" cy="2.846"
											        r="2.719"/>
											<circle cx="27.333" cy="2.846" r="2.72"/>
											<circle cx="39.369" cy="2.846" r="2.72"/>
											<circle
												cx="51.405" cy="2.846" r="2.72"/>
											<circle cx="63.441" cy="2.846" r="2.72"/>
											<circle cx="75.479" cy="2.846"
											        r="2.72"/>
											<circle cx="87.514" cy="2.846" r="2.719"/>
										</g>
										<g transform="translate(0 73)">
											<circle cx="3.261"
											        cy="2.926" r="2.72"/>
											<circle cx="15.296" cy="2.926" r="2.719"/>
											<circle cx="27.333" cy="2.926" r="2.72"/>
											<circle
												cx="39.369" cy="2.926" r="2.72"/>
											<circle cx="51.405" cy="2.926" r="2.72"/>
											<circle cx="63.441" cy="2.926"
											        r="2.72"/>
											<circle cx="75.479" cy="2.926" r="2.72"/>
											<circle cx="87.514" cy="2.926" r="2.719"/>
										</g>
										<g
											transform="translate(0 85)">
											<circle cx="3.261" cy="3.006" r="2.72"/>
											<circle cx="15.296" cy="3.006"
											        r="2.719"/>
											<circle cx="27.333" cy="3.006" r="2.72"/>
											<circle cx="39.369" cy="3.006" r="2.72"/>
											<circle
												cx="51.405" cy="3.006" r="2.72"/>
											<circle cx="63.441" cy="3.006" r="2.72"/>
											<circle cx="75.479" cy="3.006"
											        r="2.72"/>
											<circle cx="87.514" cy="3.006" r="2.719"/>
										</g>
									</g>
								</g>
							</g>
						</svg>
					</div>
					<!-- register -->
					<div class="w-full mt-20 mr-0 mb-0 ml-0 relative z-10 max-w-2xl lg:mt-0 lg:w-5/12 hidden">
						<div
							class="flex flex-col items-start justify-start pt-10 pr-10 pb-10 pl-10 bg-white shadow-2xl rounded-xl relative z-10">
							<p class="w-full text-4xl font-medium text-center leading-snug font-serif">Sign up for an
								account</p>
							<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>" class="w-full">
								<input type="hidden" name="action" value="postmasterpro_register">
								<div class="w-full mt-6 mr-0 mb-0 ml-0 relative space-y-8">
									<div class="relative">
										<p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
											Full Name</p>
										<input placeholder="i.e Michael Doe" type="text"
										       class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"/>
									</div>
									<div class="relative">
										<p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
											Email</p>
										<input placeholder="i.e michael@doex.com" type="text"
										       class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"/>
									</div>
									<div class="relative">
										<p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
											Password</p>
										<input placeholder="********" type="password" autocomplete="current-password"
										       class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"/>
									</div>
									<div class="relative">
										<p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
											Confirm Password</p>
										<input placeholder="********" type="password" autocomplete="current-password"
										       class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"/>
									</div>
									<div class="relative">
										<button type="submit"
										        class="w-full inline-block pt-4 pr-5 pb-4 pl-5 text-xl font-medium text-center text-white bg-indigo-500 rounded-lg transition duration-200 hover:text-white hover:bg-indigo-600 ease">
											Register
										</button>
									</div>
								</div>
							</form>
						</div>
						<svg viewbox="0 0 91 91"
						     class="absolute top-0 left-0 z-0 w-32 h-32 -mt-12 -ml-12 text-yellow-300 fill-current">
							<g stroke="none" strokewidth="1" fillrule="evenodd">
								<g fillrule="nonzero">
									<g>
										<g>
											<circle
												cx="3.261" cy="3.445" r="2.72"/>
											<circle cx="15.296" cy="3.445" r="2.719"/>
											<circle cx="27.333" cy="3.445"
											        r="2.72"/>
											<circle cx="39.369" cy="3.445" r="2.72"/>
											<circle cx="51.405" cy="3.445" r="2.72"/>
											<circle cx="63.441"
											        cy="3.445" r="2.72"/>
											<circle cx="75.479" cy="3.445" r="2.72"/>
											<circle cx="87.514" cy="3.445" r="2.719"/>
										</g>
										<g
											transform="translate(0 12)">
											<circle cx="3.261" cy="3.525" r="2.72"/>
											<circle cx="15.296" cy="3.525"
											        r="2.719"/>
											<circle cx="27.333" cy="3.525" r="2.72"/>
											<circle cx="39.369" cy="3.525" r="2.72"/>
											<circle
												cx="51.405" cy="3.525" r="2.72"/>
											<circle cx="63.441" cy="3.525" r="2.72"/>
											<circle cx="75.479" cy="3.525"
											        r="2.72"/>
											<circle cx="87.514" cy="3.525" r="2.719"/>
										</g>
										<g transform="translate(0 24)">
											<circle cx="3.261"
											        cy="3.605" r="2.72"/>
											<circle cx="15.296" cy="3.605" r="2.719"/>
											<circle cx="27.333" cy="3.605" r="2.72"/>
											<circle
												cx="39.369" cy="3.605" r="2.72"/>
											<circle cx="51.405" cy="3.605" r="2.72"/>
											<circle cx="63.441" cy="3.605"
											        r="2.72"/>
											<circle cx="75.479" cy="3.605" r="2.72"/>
											<circle cx="87.514" cy="3.605" r="2.719"/>
										</g>
										<g
											transform="translate(0 36)">
											<circle cx="3.261" cy="3.686" r="2.72"/>
											<circle cx="15.296" cy="3.686"
											        r="2.719"/>
											<circle cx="27.333" cy="3.686" r="2.72"/>
											<circle cx="39.369" cy="3.686" r="2.72"/>
											<circle
												cx="51.405" cy="3.686" r="2.72"/>
											<circle cx="63.441" cy="3.686" r="2.72"/>
											<circle cx="75.479" cy="3.686"
											        r="2.72"/>
											<circle cx="87.514" cy="3.686" r="2.719"/>
										</g>
										<g transform="translate(0 49)">
											<circle cx="3.261"
											        cy="2.767" r="2.72"/>
											<circle cx="15.296" cy="2.767" r="2.719"/>
											<circle cx="27.333" cy="2.767" r="2.72"/>
											<circle
												cx="39.369" cy="2.767" r="2.72"/>
											<circle cx="51.405" cy="2.767" r="2.72"/>
											<circle cx="63.441" cy="2.767"
											        r="2.72"/>
											<circle cx="75.479" cy="2.767" r="2.72"/>
											<circle cx="87.514" cy="2.767" r="2.719"/>
										</g>
										<g
											transform="translate(0 61)">
											<circle cx="3.261" cy="2.846" r="2.72"/>
											<circle cx="15.296" cy="2.846"
											        r="2.719"/>
											<circle cx="27.333" cy="2.846" r="2.72"/>
											<circle cx="39.369" cy="2.846" r="2.72"/>
											<circle
												cx="51.405" cy="2.846" r="2.72"/>
											<circle cx="63.441" cy="2.846" r="2.72"/>
											<circle cx="75.479" cy="2.846"
											        r="2.72"/>
											<circle cx="87.514" cy="2.846" r="2.719"/>
										</g>
										<g transform="translate(0 73)">
											<circle cx="3.261"
											        cy="2.926" r="2.72"/>
											<circle cx="15.296" cy="2.926" r="2.719"/>
											<circle cx="27.333" cy="2.926" r="2.72"/>
											<circle
												cx="39.369" cy="2.926" r="2.72"/>
											<circle cx="51.405" cy="2.926" r="2.72"/>
											<circle cx="63.441" cy="2.926"
											        r="2.72"/>
											<circle cx="75.479" cy="2.926" r="2.72"/>
											<circle cx="87.514" cy="2.926" r="2.719"/>
										</g>
										<g
											transform="translate(0 85)">
											<circle cx="3.261" cy="3.006" r="2.72"/>
											<circle cx="15.296" cy="3.006"
											        r="2.719"/>
											<circle cx="27.333" cy="3.006" r="2.72"/>
											<circle cx="39.369" cy="3.006" r="2.72"/>
											<circle
												cx="51.405" cy="3.006" r="2.72"/>
											<circle cx="63.441" cy="3.006" r="2.72"/>
											<circle cx="75.479" cy="3.006"
											        r="2.72"/>
											<circle cx="87.514" cy="3.006" r="2.719"/>
										</g>
									</g>
								</g>
							</g>
						</svg>
						<svg viewbox="0 0 91 91"
						     class="absolute bottom-0 right-0 z-0 w-32 h-32 -mb-12 -mr-12 text-indigo-500 fill-current">
							<g stroke="none" strokewidth="1" fillrule="evenodd">
								<g fillrule="nonzero">
									<g>
										<g>
											<circle
												cx="3.261" cy="3.445" r="2.72"/>
											<circle cx="15.296" cy="3.445" r="2.719"/>
											<circle cx="27.333" cy="3.445"
											        r="2.72"/>
											<circle cx="39.369" cy="3.445" r="2.72"/>
											<circle cx="51.405" cy="3.445" r="2.72"/>
											<circle cx="63.441"
											        cy="3.445" r="2.72"/>
											<circle cx="75.479" cy="3.445" r="2.72"/>
											<circle cx="87.514" cy="3.445" r="2.719"/>
										</g>
										<g
											transform="translate(0 12)">
											<circle cx="3.261" cy="3.525" r="2.72"/>
											<circle cx="15.296" cy="3.525"
											        r="2.719"/>
											<circle cx="27.333" cy="3.525" r="2.72"/>
											<circle cx="39.369" cy="3.525" r="2.72"/>
											<circle
												cx="51.405" cy="3.525" r="2.72"/>
											<circle cx="63.441" cy="3.525" r="2.72"/>
											<circle cx="75.479" cy="3.525"
											        r="2.72"/>
											<circle cx="87.514" cy="3.525" r="2.719"/>
										</g>
										<g transform="translate(0 24)">
											<circle cx="3.261"
											        cy="3.605" r="2.72"/>
											<circle cx="15.296" cy="3.605" r="2.719"/>
											<circle cx="27.333" cy="3.605" r="2.72"/>
											<circle
												cx="39.369" cy="3.605" r="2.72"/>
											<circle cx="51.405" cy="3.605" r="2.72"/>
											<circle cx="63.441" cy="3.605"
											        r="2.72"/>
											<circle cx="75.479" cy="3.605" r="2.72"/>
											<circle cx="87.514" cy="3.605" r="2.719"/>
										</g>
										<g
											transform="translate(0 36)">
											<circle cx="3.261" cy="3.686" r="2.72"/>
											<circle cx="15.296" cy="3.686"
											        r="2.719"/>
											<circle cx="27.333" cy="3.686" r="2.72"/>
											<circle cx="39.369" cy="3.686" r="2.72"/>
											<circle
												cx="51.405" cy="3.686" r="2.72"/>
											<circle cx="63.441" cy="3.686" r="2.72"/>
											<circle cx="75.479" cy="3.686"
											        r="2.72"/>
											<circle cx="87.514" cy="3.686" r="2.719"/>
										</g>
										<g transform="translate(0 49)">
											<circle cx="3.261"
											        cy="2.767" r="2.72"/>
											<circle cx="15.296" cy="2.767" r="2.719"/>
											<circle cx="27.333" cy="2.767" r="2.72"/>
											<circle
												cx="39.369" cy="2.767" r="2.72"/>
											<circle cx="51.405" cy="2.767" r="2.72"/>
											<circle cx="63.441" cy="2.767"
											        r="2.72"/>
											<circle cx="75.479" cy="2.767" r="2.72"/>
											<circle cx="87.514" cy="2.767" r="2.719"/>
										</g>
										<g
											transform="translate(0 61)">
											<circle cx="3.261" cy="2.846" r="2.72"/>
											<circle cx="15.296" cy="2.846"
											        r="2.719"/>
											<circle cx="27.333" cy="2.846" r="2.72"/>
											<circle cx="39.369" cy="2.846" r="2.72"/>
											<circle
												cx="51.405" cy="2.846" r="2.72"/>
											<circle cx="63.441" cy="2.846" r="2.72"/>
											<circle cx="75.479" cy="2.846"
											        r="2.72"/>
											<circle cx="87.514" cy="2.846" r="2.719"/>
										</g>
										<g transform="translate(0 73)">
											<circle cx="3.261"
											        cy="2.926" r="2.72"/>
											<circle cx="15.296" cy="2.926" r="2.719"/>
											<circle cx="27.333" cy="2.926" r="2.72"/>
											<circle
												cx="39.369" cy="2.926" r="2.72"/>
											<circle cx="51.405" cy="2.926" r="2.72"/>
											<circle cx="63.441" cy="2.926"
											        r="2.72"/>
											<circle cx="75.479" cy="2.926" r="2.72"/>
											<circle cx="87.514" cy="2.926" r="2.719"/>
										</g>
										<g
											transform="translate(0 85)">
											<circle cx="3.261" cy="3.006" r="2.72"/>
											<circle cx="15.296" cy="3.006"
											        r="2.719"/>
											<circle cx="27.333" cy="3.006" r="2.72"/>
											<circle cx="39.369" cy="3.006" r="2.72"/>
											<circle
												cx="51.405" cy="3.006" r="2.72"/>
											<circle cx="63.441" cy="3.006" r="2.72"/>
											<circle cx="75.479" cy="3.006"
											        r="2.72"/>
											<circle cx="87.514" cy="3.006" r="2.719"/>
										</g>
									</g>
								</g>
							</g>
						</svg>
					</div>
				</div>

			<?php endif; ?>

		</div>
	</div>
</div>
<script>
    function postMasterApp() {
        const token = '<?php echo get_option( 'postmasterpro_auth_token', '' ); ?>';
        const baseUrl = 'https://api.upworkstation.com/api'
        return {
            isLoading: false,
            errorMessage: '',
            successMessage: '',
            email: '',
            password: '',
            userName: 'friend',
            login: async function () {
                this.isLoading = true;
                this.errorMessage = '';
                this.successMessage = '';

                try {
                    const response = await fetch(baseUrl + '/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            email: this.email,
                            password: this.password
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.successMessage = 'You have been logged in successfully';
                        this.saveToken(data.data.token);
                    } else {
                        this.errorMessage = data.message || 'Unable to authenticate your credentials. Are you sure you have entered the correct credentials?';
                    }
                } catch (error) {
                    console.log(error);
                    this.errorMessage = 'Unable to login. Please try again later.';
                } finally {
                    this.isLoading = false;
                }
            },
            saveToken: async function (token) {
                try {
                    const response = await fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            action: 'postmasterpro_save_token',
                            token: token,
                            _ajax_nonce: '<?php echo wp_create_nonce( 'postmasterpro_save_token_nonce' ); ?>'
                        })
                    });

                    if (response.ok) {
                        window.location.reload();
                    } else {
                        this.errorMessage = 'Error saving token.';
                    }
                } catch (error) {
                    this.errorMessage = 'Error saving token.';
                }
            },
            logout: async function () {
                try {
                    const response = await fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            action: 'postmasterpro_logout',
                            _ajax_nonce: '<?php echo wp_create_nonce( 'postmasterpro_logout_nonce' ); ?>'
                        })
                    });

                    if (response.ok) {
                        window.location.reload();
                    } else {
                        console.error('Error logging out.');
                    }
                } catch (error) {
                    console.error('Error logging out.');
                }
            },
            fetchQuestion: async function () {
                if (!token) {
                    console.error('User is not logged in.');
                    return;
                }
                try {
                    const response = await fetch(baseUrl + '/question', {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        const responseData = await response.json();
                        if (responseData.success) {
                            await this.publishQuestion(responseData.data.question);
                        } else {
                            console.error('Error fetching question.');
                        }
                    } else {
                        console.error('Error fetching question.');
                    }
                } catch (error) {
                    console.error('Error fetching question.');
                }
            },
            fetchUser: async function () {
                if (!token) {
                    console.error('User is not logged in.');
                    return;
                }
                try {
                    const response = await fetch(baseUrl + '/user', {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        const responseData = await response.json();
                        if (responseData.success) {
                            this.userName = responseData.data.auth_user.name;
                        } else {
                            console.error('Error fetching user.');
                        }
                    } else {
                        console.error('Error fetching user.');
                    }
                } catch (error) {
                    console.error('Error fetching user.');
                }
            },
            publishQuestion: async function (question) {
                try {
                    const response = await fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            action: 'postmasterpro_publish_question',
                            question: JSON.stringify(question),
                            _ajax_nonce: '<?php echo wp_create_nonce( 'postmasterpro_publish_question_nonce' ); ?>'
                        })
                    });

                    if (!response.ok) {
                        console.error('Error publishing question.');
                    }
                } catch (error) {
                    console.error('Error publishing question.');
                }
            },
        };
    }
</script>
