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
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg" v-if="state.isLoading">
                    <LoadingSpinner />
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg" v-else>
                    <div class="flex flex-wrap items-center gap-3 px-10 pt-4 pb-2">
                        <h3>Filter by director:</h3>
                        <div class="flex gap-2 flex-wrap">
                            <span v-for="director in state.directors" :key="director" @click="filterMovies(director, $event)" 
                                class="inline-block text-sm font-semibold text-gray-700 bg-gray-200 rounded-full filter"
                                :class="{active: state.filter === director}"
                            >
                                {{ director }}
                            </span>
                        </div>
                    </div>

                    <ul class="grid grid-cols-1 gap-5 p-10 mx-auto sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3" >
                        <Card v-for="movie in state.movies" :key="movie.uid" :movie="movie" />
                    </ul>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated';
    import Checkbox from '@/Components/Checkbox';
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
            Checkbox
		},

		props: [
			'api'
		],
		
		setup(props) {

			const state = reactive({
				isLoading: false,
				fetchedMovies: [],
				movies: [],
				directors: [],
                filter: '',
			});

			const authUser = computed(() => usePage().props.value.auth.user);

			const { api } = props;
            const route = `${api}/films`;
            
			const getMovies = async () => {
				state.isLoading = true;
				await axios.get(route)
				.then(response => {
					state.fetchedMovies = response.data.result
					state.isLoading = false;
				}).then(response => {
					state.movies = state.fetchedMovies
    			    getDirectors();
                })
			};

			const filterMovies = (filter, event) => {
                event.target.classList.toggle('active');
                if(state.filter === filter){
                    state.filter = ''
                    state.movies = state.fetchedMovies;
                    return;
                } else {
                    state.filter = filter;
                }

                state.movies = state.fetchedMovies.filter((movie) => {
                    if(movie.properties.director === state.filter){
                        return movie;
                    }
                })
			};

			const getDirectors = () => {
                state.fetchedMovies.map((movie) => {
                    const director = movie.properties.director;
                    if(!state.directors.includes(director)){
                        state.directors.push(director);
                    }
                })
			};

            onBeforeMount(() => {
			    getMovies();
		    })

			return { state, authUser, filterMovies }
		}
	}
</script>

<style scoped>
    .filter{
        padding: 5px 10px;
        border: 2px solid transparent;
        cursor: pointer;
        user-select: none; 
        transition: all 0.3s;
    }
    .filter.active{
        border: 2px solid black;
        background-color: #FFE919;
        color: black;
        font-weight: bold;
    }
</style>