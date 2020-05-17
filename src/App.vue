<template>
	<div id="app">
		<div class="container my-5">
			<header>
				<div class="d-flex align-items-center">
					<h1
						class="text-left text-muted mb-0 mr-3 font-weight-light"
					>
						| to<span class="text-primary">do</span>'s
					</h1>
					<Message />
				</div>
			</header>
			<div class="shadow-sm">
				<CreateTodo />
				<List />
			</div>
			<Pagination />
			<SpeedBump v-if="showSpeedBump"/>
		</div>
	</div>
</template>

<script>
import List from './components/TodoList';
import CreateTodo from './components/CreateTodo';
import Pagination from './components/Pagination';
import Message from './components/shared/Message';
import SpeedBump from './components/shared/SpeedBump';
import { mapActions, mapState } from 'vuex';

export default {
	components: {
		List,
		Message,
		CreateTodo,
		SpeedBump,
		Pagination
	},
	computed: {
		...mapState(['todos', 'pagination', 'showSpeedBump'])
	},
	created() {
		this.getTodos({});
	},
	methods: {
		...mapActions(['getTodos'])
	}
};
</script>

<style lang="scss">
#app {
	font-family: Avenir, Helvetica, Arial, sans-serif;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	text-align: center;
	color: #2c3e50;
}

.slanted-bottom {
	height: 100px;
	-webkit-clip-path: polygon(0% 0%, 100% 0%, 100% 100%, -100% 0%);
	clip-path: polygon(0% 0%, 100% 0%, 100% 100%, -100% 0%);
}
.slanted-top {
	height: 25px;
	-webkit-clip-path: polygon(0% 96%, 100% 0%, 100% 100%, 0% 100%);
	clip-path: polygon(0% 96%, 100% 0%, 100% 100%, 0% 100%);
}

</style>
