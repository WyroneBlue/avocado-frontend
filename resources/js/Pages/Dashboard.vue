<template>
    <Head title="Dashboard | Movies" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <LoadingSpinner v-if="state.isLoading"/>
                    <ul class="grid grid-cols-1 gap-5 p-10 mx-auto sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3" v-else>
                        <Card v-for="movie in state.movies" :key="movie.uid" :movie="movie" />
                    </ul>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated';
	import { computed, reactive, onBeforeMount } from 'vue';
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
			'api'
		],
		
		setup(props) {

			const state = reactive({
				isLoading: false,
				movies: [],
			});

			const authUser = computed(() => usePage().props.value.auth.user);

			const { api } = props;
            const route = `${api}/films`;
            
			const getMovies = async () => {
				state.isLoading = true;
				await axios.get(route)
				.then(response => {
					state.movies = response.data.result
					state.isLoading = false;
				})
			};

            onBeforeMount(() => {
			    getMovies();
		    })

			return { state, authUser }
		}
	}
</script>