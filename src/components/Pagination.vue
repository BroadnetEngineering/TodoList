<template>
	<div class="slanted slanted-bottom pagniation-wrapper bg-primary">
		<nav
			aria-label="Page navigation example"
			v-if="pagination.totalResults > todos.length && todos.length"
		>
			<ul class="pagination justify-content-end pt-3 pr-3">
				<li class="page-item">
					<a
						class="page-link rounded-0 border-0 bg-transparent text-white"
						@click.prevent="prevNext(-1)"
						href="javascript:void(0)"
						v-if="pagination.currentPage !== 1"
						>Previous</a
					>
				</li>
				<li
					class="page-item"
					v-for="(page, index) in numberOfPages"
					:key="`page-${page}-${index}`"
				>
					<a
						@click.prevent="setCurrentPage(page)"
						class="page-link border-0 rounded-0 bg-transparent text-white"
						href="javascript:void(0)"
						v-if="pagination.currentPage !== page"
						>{{ page }}</a
					>
					<span
						class="text-primary border-0 bg-light page-link rounded-0"
						v-else
					>
						{{ page }}
					</span>
				</li>
				<li
					class="page-item"
					v-if="pagination.currentPage !== numberOfPages"
				>
					<a
						class="page-link rounded-0 border-0 bg-transparent text-white"
						@click.prevent="prevNext(1)"
						href="javascript:void(0)"
						>Next</a
					>
				</li>
			</ul>
		</nav>
	</div>
</template>

<script>
import { mapActions, mapState, mapMutations } from 'vuex';

export default {
	computed: {
		...mapState(['pagination', 'todos']),
		numberOfPages() {
			const numberOfPages = Math.ceil(
				this.pagination.totalResults / this.pagination.rowsPerPage
			);

			return numberOfPages;
		}
	},
	methods: {
		...mapMutations(['SET_CURRENT_PAGE']),
		...mapActions(['getTodos']),
		prevNext,
		setCurrentPage
	}
};

/**
 * Sets the page number we are on to the store
 * @param {Number} - page
 */
function prevNext(page) {
	if (!page) {
		return;
	}

	const nextPage = (this.pagination.currentPage += page);
	this.SET_CURRENT_PAGE(nextPage);
}

/**
 * Sets the page number we are on to the store
 * @param {Number} - pageNumber
 */
function setCurrentPage(pageNumber) {
	if (!pageNumber) {
		return;
	}

	this.SET_CURRENT_PAGE(pageNumber);
	this.getTodos({ currentPage: pageNumber });
}
</script>
