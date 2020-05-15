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
	}
};
