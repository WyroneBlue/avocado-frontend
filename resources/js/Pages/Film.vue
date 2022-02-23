<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800" v-if="state.isLoading">
                Movie: loading...
            </h2>
            <h2 class="text-xl font-semibold leading-tight text-gray-800" v-else-if="state.movieFound">
                Movie: {{ state.movie.properties.title }}
            </h2>
            <h2 class="text-xl font-semibold leading-tight text-gray-800" v-else>
                Movie not found
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
					<div class="container p-4 mx-auto mt-32 md:p-0">
                        <LoadingSpinner v-if="state.isLoading"/>
						<div class="flex flex-wrap w-full mx-auto shadow-lg lg:w-4/5" v-else-if="state.movieFound">

							<div class="relative w-full h-64 bg-bottom bg-cover border md:w-1/2 md:h-auto" style="background-image:url('/storage/images/starwars-placeholder.png')">
								<div class="absolute text-xl">
									<i class="mt-4 ml-4 text-white cursor-pointer fa fa-heart hover:text-red-light"></i>
								</div>
							</div>

							<div class="w-full bg-white md:w-1/2">
								<div class="relative h-full px-6 mx-auto md:px-0 md:pt-6 md:-ml-6">
									<div class="relative flex flex-wrap items-center p-6 mb-4 -mt-6 bg-white lg:h-full md:mt-0 md:mb-0 md:flex-wrap">
										<div class="w-full text-center lg:w-1/5 lg:border-right lg:border-solid md:text-left">
											<h3>{{ state.movie.properties.title }} - episode: {{ state.movie.properties.episode_id }}</h3>
											<p class="mt-3 mb-0 text-sm italic text-grey-dark">{{ state.movie.description }}</p>
											<p class="mt-3 mb-0 text-sm italic text-grey-dark">release date: {{ state.movie.properties.release_date }}</p>
											<hr class="w-1/4 mt-4 border md:ml-0 lg:hidden">
										</div>

										<div class="w-full lg:w-3/5 lg:px-3">
											<p class="mt-4 text-sm text-justify text-md lg:mt-0 md:text-left">
											{{ state.movie.properties.opening_crawl }}
											</p>
										</div>

										<div class="w-full mt-6 text-center lg:w-1/5 lg:mt-0 lg:px-4 md:text-left">
											<button class="w-1/3 py-2 bg-white border border-solid hover:bg-grey-darker hover:text-white border-grey lg:w-full">Visit now</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div v-else>
							<h2>The movie you're looking for does not exist</h2>
						</div>
					</div>
				</div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated';
	import { computed, reactive } from 'vue';
	import Card from '@/Components/MovieCard';
	import { Head, usePage, Link } from '@inertiajs/inertia-vue3'
	import LoadingSpinner from '@/components/LoadingSpinner';
	export default {
		
		components: {
            BreezeAuthenticatedLayout,
            Head,
			Card,
			Link,
			LoadingSpinner,
		},

		props: [
			'api',
			'movieId'
		],
		
		setup(props) {

			const state = reactive({
				isLoading: false,
				movie: [],
				movieFound: false,
			});

			const authUser = computed(() => usePage().props.value.auth.user);

			const { api, movieId } = props;
            const route = `${api}/films/${movieId}`;
            
			const getMovie = async () => {
				state.isLoading = true;
				await axios.get(route)
				.then(response => {
					state.movie = response.data.result
					state.isLoading = false;
					state.movieFound = true;
				})
				.catch(error => { state.movieFound = true })
			};

			getMovie();
			
			return { state, authUser }
		}
	}
</script>