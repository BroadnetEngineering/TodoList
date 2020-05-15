<template>
	<input
		class="form-control w-100"
		type="search"
		placeholder="Search todo's..."
	/>
</template>

<script>
import { mapState } from 'vuex';

export default {
	computed: {
		...mapState(['todos'])
	}
};
</script>
