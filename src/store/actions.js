import axios from 'axios';
import * as mutationTypes from './mutation-types';
import { v4 as uuidv4 } from 'uuid';

const DB_URL = 'http://localhost:3000';

export const getTodos = ({ state, commit }) => {
	return axios
		.get(`${DB_URL}/todos?_sort=id&_order=asc`)
		.then(result => {
			console.log(result);
			debugger;
			commit(mutationTypes.SET_TODOS, result.data);
		})
		.catch(err => {
			console.log(err);
		});
};

export const createTodo = ({ state, commit }, todo) => {
	const newTodo = {
		id: uuidv4(),
		...todo
	};

	return axios
		.post(`${DB_URL}/todos`, newTodo)
		.then(result => {
			commit(mutationTypes.ADD_TODO, result.data);
		})
		.catch(err => {
			console.log(err);
		});
};

export const deleteTodo = ({ state, commit, dispatch }, { id }) => {
	return axios
		.delete(`${DB_URL}/todos/${id}/`)
		.then(result => {
			dispatch('getTodos');
		})
		.catch(err => {
			console.log(err);
		});
};

export const updateTodo = ({ state, commit, dispatch }, todo) => {
	return axios
		.put(`${DB_URL}/todos/${todo.id}/`, todo)
		.then(result => {
			dispatch('getTodos');
		})
		.catch(err => {
			console.log(err);
		});
};
