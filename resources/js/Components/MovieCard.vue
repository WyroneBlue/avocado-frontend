<template>
	<li ref="card" class="movie-card"
    @mouseleave="toggleHover"
    @mouseenter="toggleHover"
    >
        <Link :href="route('db.films.details', movie.uid)">
            <div class="overflow-hidden rounded shadow-lg">
                <img class="w-full" :src="movie.properties.img ?? '/storage/images/starwars-placeholder.png'" alt="Forest">
                <div class="px-6 py-4">
                    <div class="mb-2 text-xl font-bold">{{ movie.properties.title }}</div>
                    <p class="text-base text-gray-700">{{ movie.properties.opening_crawl.slice(0, 100) }}...</p>
                </div>
                <div class="w-full px-6 py-4 text-center lg:block lg:px-4 md:text-left">
                    <Link :href="route('db.films.details', movie.uid)" class="px-4 py-2 bg-white border border-solid hover:bg-grey-darker hover:font-black border-grey lg:w-full">
                        Show more
                    </Link>
                </div>
            </div>
        </Link>
	</li>

</template>
<script>

import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'

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

		return { 
            card,
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