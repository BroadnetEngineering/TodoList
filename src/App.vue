<template>
	<div id="app">
		<div class="container my-5">
			<h1>Your ToDos</h1>
			<Nav />
			<list />
		</div>
	</div>
</template>

<script>
import List from './components/TodoList';
import Nav from './components/Nav';
import { mapActions } from 'vuex';

export default {
	components: {
		List,
		Nav
	},
	created() {
		this.getTodos();
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
</style>
