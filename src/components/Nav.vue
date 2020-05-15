<template
	><header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded-top">
			<a
				class="navbar-brand"
				href="javascript:void(0)"
				@click.prevent="showAddTodoForm = true"
				>+</a
			>
			<Search />
		</nav>
		<div
			class="form-group p-3 m-0 form-inline d-flex w-100 border-right border-left"
			v-if="showAddTodoForm"
		>
			<div class="mr-3"><label>Add New Todo: </label></div>
			<div class="flex-grow-1">
				<input
					type="text"
					class="form-control w-100"
					placeholder="Enter Todo Title ..."
					v-model="todo.title"
				/>
			</div>
			<div>
				<button
					@click="addTodo"
					type="submit"
					class="btn btn-primary ml-3"
				>
					Add Todo
				</button>
			</div>
		</div>
	</header>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import Search from './Search';

export default {
	data() {
		return {
			showAddTodoForm: false,
			todo: {
				completed: false,
				title: ''
			}
		};
	},
	components: {
		Search
	},
	computed: {
		...mapState(['todos'])
	},
	methods: {
		...mapActions(['createTodo']),
		addTodo
	}
};

/**
 * Updates the todo
 * @param Object - todo
 */
function addTodo(todo) {
	this.createTodo(this.todo);
}
</script>

<style></style>
