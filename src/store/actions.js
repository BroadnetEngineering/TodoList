import axios from 'axios';
import * as mutationTypes from './mutation-types';
import { v4 as uuidv4 } from 'uuid';
import { messages, network } from '../constants';
import store from './';

const DB_URL = 'http://localhost:3000';

export const getTodos = ({ state, commit }, { searchTerm = '' }) => {
	const sharedParams = `&_limit=${state.pagination.rowsPerPage}`;
	const defaultParams = `?_sort=created&_order=desc&_page=${state.pagination.currentPage}`;
	const serarchParams = `?q=${searchTerm}&_limit=${state.pagination.rowsPerPage}`;
	const requestParams = searchTerm ? serarchParams : defaultParams;

	return axios
		.get(`${DB_URL}/todos${requestParams}${sharedParams}`)
		.then(result => {
			console.log(result);

			const totalCount = result.headers['x-total-count'];
			const totalResults = parseInt(totalCount) || result.data.length;

			commit(mutationTypes.SET_TODOS, result.data);
			commit(mutationTypes.SET_TOTAL_RESULTS, totalResults);

			if (totalResults === 0) {
				commit(mutationTypes.SET_MESSAGE, {
					type: 'danger',
					content: messages.REFINE_SEARCH
				});
			}
		})
		.catch(error => {
			handleErrors(error);
		});
};

export const createTodo = ({ state, commit, dispatch }, todo) => {
	const newTodo = {
		id: uuidv4(),
		created: new Date(),
		...todo
	};

	return axios
		.post(`${DB_URL}/todos`, newTodo)
		.then(result => {
			commit(mutationTypes.ADD_TODO, result.data);
			commit(mutationTypes.SET_MESSAGE, {
				type: 'success',
				content: messages.TODO_CREATED
			});
			dispatch('getTodos', {});
		})
		.catch(error => {
			handleErrors(error);
		});
};

export const deleteTodo = ({ state, commit, dispatch }, { id }) => {
	return axios
		.delete(`${DB_URL}/todos/${id}/`)
		.then(result => {
			dispatch('getTodos', {});
			commit(mutationTypes.SET_MESSAGE, {
				type: 'success',
				content: messages.TODO_DELETED
			});
		})
		.catch(error => {
			handleErrors(error);
		});
};

export const updateTodo = ({ state, commit, dispatch }, todo) => {
	return axios
		.put(`${DB_URL}/todos/${todo.id}/`, todo)
		.then(result => {
			dispatch('getTodos');
			commit(mutationTypes.SET_MESSAGE, {
				type: 'success',
				content: messages.TODO_UPDATED
			});
		})
		.catch(error => {
			handleErrors(error);
		});
};

/**
 * Handles errors for api calls
 */
function handleErrors(error) {
	console.log('error', store);
	console.log('error', error);
	console.log('error', error.message);
	if (error.message === 'Network Error') {
		store.commit(mutationTypes.SET_MESSAGE, {
			type: 'danger',
			content: network.NETWORK_ERROR
		});
	}
}
