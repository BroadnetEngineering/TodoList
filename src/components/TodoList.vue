<template>
	<main>
		<div class="rounded-bottom">
			<div
				class="list-group-item list-group-item-action d-flex w-100"
				v-for="(todo, index) in todos"
				:key="`todo-${index}`"
			>
				<div class="pr-3">
					<input
						:checked="todo.completed"
						@change="updateTodoInfo(todo, $event)"
						type="checkbox"
						:value="todo.id"
					/>
				</div>
				<div class="flex-grow-1 text-left">
					{{ todo.title }}
				</div>
				<div>
					<a href="javascript:void(0)" @click="removeTodo(todo)">
						delete
					</a>
				</div>
			</div>
		</div>
	</main>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
	data() {
		return {};
	},
	computed: {
		...mapState(['todos'])
	},
	methods: {
		removeTodo,
		updateTodoInfo,
		...mapActions(['deleteTodo', 'updateTodo'])
	}
};

/**
 * Deletes todo
 * @param {Object} - todo
 */
function removeTodo(todo) {
	if (!todo && !todo.id) {
		return;
	}

	this.deleteTodo(todo);
}

/**
 * Updates todo
 * @param {Object} - todo
 */
function updateTodoInfo(todo, event) {
	debugger;
	if (!todo) {
		return;
	}

	todo.completed = event.target.checked;
	this.updateTodo(todo);
}
</script>
