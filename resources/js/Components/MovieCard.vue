<template>
	<li ref="card" class="movie-card"
    @mouseleave="toggleHover"
    @mouseenter="toggleHover"
    @click="goToDetails(movie.uid)" 
    >
        <div class="overflow-hidden rounded shadow-lg">
            <img class="w-full" :src="movie.properties.img ?? '/storage/images/starwars-placeholder.png'" alt="Forest">
            <div class="px-6 py-4">
                <div class="mb-2 text-xl font-bold">{{ movie.properties.title }}</div>
                <p class="text-base text-gray-700">{{ movie.properties.opening_crawl.slice(0, 100) }}...</p>
            </div>
            <div class="px-6 pt-4 pb-2">
                <span class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full">{{ movie.properties.director }}</span>
                <span class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full">{{ movie.properties.title }}</span>
                <span class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full">{{ movie.properties.release_date }}</span>
            </div>
        </div>
	</li>

</template>
<script>

import { onMounted, onUnmounted, ref, reactive, computed } from 'vue'
import { usePage, Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

export default {

	components: {
		Link,
	},

	props: ['movie'],
	
	setup() {

        const card = ref(null);

		const toggleHover = () => {
            console.log(card.value);
			card.value.classList.toggle('hover');
		}

        const goToDetails = (id) => {
            window.location = route('db.films.details', id);
        }
        // const goToDetails = (id) => {
        //     window.location = route('db.films.details', id);
        // } 

		return { 
            card,
            goToDetails,
            toggleHover
		}
	}
}
</script>

<style scoped>
    .movie-card{
        position: relative;
        transition: transform .3s;
    }
    .movie-card.hover{
        transform: scale(1.1);
        box-shadow: 1px 1px 10px black;
        cursor: pointer;
    }
</style>