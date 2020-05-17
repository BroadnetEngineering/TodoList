import { shallowMount, createLocalVue } from '@vue/test-utils';
import Vuex from 'vuex';
import App from '@/components/CreateTodo';

const localVue = createLocalVue();

localVue.use(Vuex);

describe('App.vue', () => {
	let actions;
	let store;
	let wrapper;

	beforeEach(() => {
		actions = {
			getTodos: jest.fn()
		};
		store = new Vuex.Store({
			actions
		});

		wrapper = shallowMount(App, { store, localVue });
	});
	describe('Actions:', () => {
		it('dispatches "getTodos" when input event value is "input"', () => {
			const wrapper = shallowMount(App, { store, localVue });

			expect(wrapper.get('.nav-container'));
		});
	});

	describe('Data:', () => {
		it('dispatches "getTodos" when input event value is "input"', () => {
			expect(wrapper.vm.showSearchForm).toBe(false);
		});
	});

	// it('does not dispatch "actionInput" when event value is not "input"', () => {
	// 	const wrapper = shallowMount(App, { store, localVue });
	// 	const input = wrapper.find('input');
	// 	input.element.value = 'not input';
	// 	input.trigger('input');
	// 	expect(actions.actionInput).not.toHaveBeenCalled();
	// });

	// it('calls store action "actionClick" when button is clicked', () => {
	// 	const wrapper = shallowMount(App, { store, localVue });
	// 	wrapper.find('button').trigger('click');
	// 	expect(actions.actionClick).toHaveBeenCalled();
	// });
});
