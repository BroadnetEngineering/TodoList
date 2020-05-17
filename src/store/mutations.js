import * as types from './mutation-types';

export default {
	[types.SET_TODOS](state, payload) {
		if (!payload) {
			return;
		}
		state.todos = payload;
	},

	[types.ADD_TODO](state, payload) {
		if (!payload) {
			return;
		}
		state.todos.unshift(payload);
	},

	[types.UPDATE_TODO](state, payload) {
		if (!payload) {
			return;
		}
		state.todos = payload;
	},

	[types.DELETE_TODO](state, payload) {
		if (!payload) {
			return;
		}
		state.todos = payload;
	},

	[types.SET_TOTAL_RESULTS](state, payload) {
		if (!payload) {
			return;
		}

		state.pagination.totalResults = payload;
	},

	[types.SET_CURRENT_PAGE](state, payload) {
		if (!payload) {
			return;
		}

		state.pagination.currentPage = payload;
	},

	[types.SET_MESSAGE](state, payload) {
		if (!payload) {
			return;
		}

		state.message = payload;
	},

	[types.SHOW_SPEED_BUMP](state, payload) {
		state.showSpeedBump = payload;
	},

	[types.SET_SPEED_BUMP](state, payload) {
		state.speedBump = payload;
	},

	[types.RESET_SPEED_BUMP](state) {
		state.speedBump = {};
	}
};
